<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\IdRequest;
use App\Http\Requests\PermissionAddRequest;
use App\Http\Requests\PermissionEditRequest;
use App\Model\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PermissionController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Permission::orderBy('id', 'desc')->paginate();

        return view('admin.permission.permissionList', [
            'data' => $data,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.permission.permissionAdd');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionAddRequest $request)
    {
        $data = new Permission ();
        $data ['name'] = $request ['name'];
        $data ['display_name'] = $request ['display_name'];
        $data ['description'] = $request ['description'];
        if ( !$data->save()) {
            return redirect()->back()->with('error', '添加失败!');
        }

        return redirect()->back()->with('success', '添加成功!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Permission::findOrFail($id);

        return view('admin.permission.permissionEdit', [
            'data' => $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(PermissionEditRequest $request, $id)
    {
        $yan = Permission::where('name', $request ['name'])->first();
        if ($yan && $yan ['id'] != $id) {
            return redirect()->back()->withInput()->withErrors('权限已存在 不可重复添加！');
        }
        $data ['name'] = $request ['name'];
        $data ['display_name'] = $request ['display_name'];
        $data ['description'] = $request ['description'];
        $res = Permission::where('id', $id)->update($data);
        if ( !$res) {
            return redirect()->back()->with('error', '修改失败!');
        }

        return redirect()->back()->with('success', '修改成功!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $yan = Permission::findOrFail($id);
        $data = Permission::where('id', $id)->delete();
        if ( !$data) {
            return redirect()->back()->with('error', '删除失败!');
        }

        return redirect()->back()->with('success', '删除成功!');
    }

    public function delete(IdRequest $request)
    {
        $yan = Permission::findOrFail($request->get('id'));
        $data = $yan->delete();
        if ( !$data) {
            return redirect()->back()->with('error', '删除失败!');
        }

        return redirect()->back()->with('success', '删除成功!');
    }
}
