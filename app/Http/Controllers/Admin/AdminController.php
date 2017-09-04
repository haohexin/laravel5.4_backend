<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AdminAddRequest;
use App\Http\Requests\AdminEditRequest;
use App\Model\Admin;
use App\Model\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use DB;

class AdminController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Admin::with(['roles'])->orderBy('id', 'desc')->paginate();

        return view('admin.admin.lists', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $role = Role::all();

        return view('admin.admin.add', [
            'type' => $role,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  AdminAddRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminAddRequest $request)
    {
        $admin_id = Auth::guard('admin')->user()->id;
        if ($admin_id != 1) {
            return redirect()->back()->withInput()->withErrors('权限不足！');
        }
        DB::beginTransaction();
        try {
            //admin
            $data = new Admin ();
            $data ['account'] = $request ['username'];
            $data ['remember_token'] = $request ['_token'];
            $data ['password'] = bcrypt($request->input('password'));
            $data->save();
            //role
            $yan = Admin::findOrFail($data->id);
            $yan->attachRole($request['category']);
            DB::commit();
        } catch (\Exception $e) {
            logger($e);
            DB::rollBack();

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
        $admin_id = Auth::guard('admin')->user()->id;
        if ($admin_id != 1) {
            return redirect()->back()->withInput()->withErrors('权限不足！');
        }
        $res = Admin::with(['roles'])->findOrFail($id);
        if ( !$res) {
            return redirect()->back()->withInput()->withErrors('管理员不存在！');
        }
        $res->roleId = $res->roles ? $res->roles[0]->id : 0;

        return view('admin.admin.edit', ['data' => $res, 'type' => Role::get()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  AdminEditRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminEditRequest $request, $id)
    {
        $admin_id = Auth::guard('admin')->user()->id;
        if ($admin_id != 1) {
            return redirect()->back()->withInput()->withErrors('权限不足！');
        }
        //管理员信息
        $res = Admin::findOrFail($id);
        //判断用户名是否重复
        $nameCheck = Admin::where('account', $request['username'])->first();
        if ($nameCheck) {
            if ($nameCheck->id != $res->id) {
                return redirect()->back()->with('error', '用户名不可重复!');
            }
        }
        \DB::beginTransaction();
        try {
            //修改管理员信息
            $data = [];
            $data['account'] = $request['username'];
            if ($request->has('password')) {
                $data['password'] = bcrypt($request->input('password'));
            }
            $res->update($data);
            //分配权限
            DB::table('role_user')->where('user_id', $request['id'])->update(['role_id' => $request['category']]);

            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollBack();

            return redirect()->back()->with('error', '保存失败!');
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

    }


    public function delete(Request $request)
    {
        $admin_id = Auth::guard('admin')->user()->id;
        if ($admin_id != 1) {
            return redirect()->back()->withInput()->withErrors('权限不足！');
        }
        \DB::beginTransaction();
        try {
            $yan = Admin::with(['roles'])->findOrFail($request->get('id'));
            $yan->delete();
            DB::table('role_user')->where('user_id', $request->get('id'))->delete();

            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollBack();

            return redirect()->back()->with('error', '保存失败!');
        }

        return redirect()->back()->with('success', '删除成功!');
    }
}
