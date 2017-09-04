<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\IdRequest;
use App\Http\Requests\RoleAddRequest;
use App\Model\Permission;
use App\Model\PermissionRole;
use App\Model\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Role::orderBy('id', 'desc')->paginate();

        return view('admin.permission.roleList', [
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
        return view('admin.permission.roleAdd');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleAddRequest $request)
    {
        $data = new Role ();
        $data['name'] = $request ['name'];
        $data['display_name'] = $request ['display_name'];
        $data['description'] = $request ['description'];
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
        $data = Role::findOrFail($id);

        return view('admin.permission.roleEdit', [
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
    public function update(Request $request, $id)
    {
        $yan = Role::where('name', $request ['name'])->first();
        if ($yan && $yan ['id'] != $id) {
            return redirect()->back()->withInput()->withErrors('角色已存在 不可重复添加！');
        }
        $data ['name'] = $request ['name'];
        $data ['display_name'] = $request ['display_name'];
        $data ['description'] = $request ['description'];
        $res = Role::where('id', $id)->update($data);
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
        $yan = Role::findOrFail($id);
        $data = Role::where('id', $id)->delete();
        if ( !$data) {
            return redirect()->back()->with('error', '修改失败!');
        }

        return redirect()->back()->with('success', '修改成功!');
    }


    public function delete(IdRequest $request)
    {
        $data = Role::where('id', $request->get('id'))->delete();
        if ( !$data) {
            return redirect()->back()->with('error', '修改失败!');
        }

        return redirect()->back()->with('success', '修改成功!');
    }


    public function permissionEdit(IdRequest $request)
    {
        // 所有权限
        $data = Permission::get();
        // 角色信息
        $role = Role::where('id', $request ['id'])->first();
        if ( !$role) {
            return redirect()->back()->withInput()->withErrors('角色不存在！');
        }
        // 角色已有用权限
        $yan = PermissionRole::with([
            'permission',
        ])->where('role_id', $request ['id'])->get([
            'permission_id',
        ]);
        $yan2 = [];
        foreach ($yan as $v) {
            $yan2 [] = $v ['permission_id'];
        }

        return view('admin.permission.rolePermissionEdit', [
            'data' => $data,
            'role' => $role,
            'yan'  => $yan2,
        ]);
    }

    public function permissionEditPost(IdRequest $request)
    {
        // 角色信息
        Role::findOrFail($request->id);
        \DB::beginTransaction();
        try {
            // 删除旧权限
            PermissionRole::where('role_id', $request->id)->delete();
            // 添加新权限
            if ($request['ids']) {
                foreach ($request['ids'] as $v) {
                    $permissionRole = new PermissionRole ();
                    $permissionRole['permission_id'] = $v;
                    $permissionRole['role_id'] = $request->id;
                    $permissionRole->save();
                }
            }
            \DB::commit();
        } catch (\Exception $e) {
            logger($e);
            \DB::rollBack();

            return redirect()->back()->with('error', '修改失败!');
        }

        return redirect()->back()->with('success', '修改成功!');
    }
}
