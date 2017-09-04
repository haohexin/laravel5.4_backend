<?php

namespace App\Http\Controllers\Admin;

use App\Model\Navigation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class NavController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Navigation::with('secondLevel')
            ->where('level', '1')
            ->orderBy('rank')
            ->get();

        return view('admin.nav.lists', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.nav.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $type = $request ['type'];
        $title = explode(',', $request ['name']);
        $url = explode(',', $request ['url']);
        $permission = explode(',', $request ['permission']);
        $rank = explode(',', $request ['rank']);
        $icon = explode(',', $request ['icon']);
        DB::beginTransaction();
        try {
            foreach ($title as $k => $v) {
                if ($v) {
                    $data = new Navigation();
                    $data ['name'] = $v;
                    $data ['url'] = $url[ $k ];
                    $data ['permission'] = $permission[ $k ];
                    $data ['rank'] = $rank[ $k ];
                    $data ['icon'] = $icon[ $k ];
                    if ($type == '1') {
                        $data ['level'] = 1;
                        $data ['fid'] = 0;
                        $res = Navigation::where('fid', 0)
                            ->orderBy('code', 'desc')
                            ->first();
                        $data ['code'] = $res ? $res->code + 10000 : 10000;
                    } elseif ($type == '2') {
                        $data ['level'] = 2;
                        $province_id = $request ['province'];
                        if ($province_id != 0) {
                            $province = Navigation::find($province_id);
                            $data ['fid'] = $province->code;
                            $res = Navigation::where('fid', $province->code)
                                ->orderBy('code', 'desc')
                                ->first();
                            if ( !empty ($res)) {
                                $data ['code'] = $res->code + 100;
                            } else {
                                $data ['code'] = $data ['fid'] + 100;
                            }
                        } else {
                            return redirect()->back()->with('error', '添加失败!');
                        }
                    } elseif ($type == '3') {
                        $data ['level'] = 3;
                        $city_id = $request ['city'];
                        if ($city_id != 0) {
                            $city = Navigation::find($city_id);
                            $data ['fid'] = $city->code;
                            $res = Navigation::where('fid', $city->code)
                                ->orderBy('code', 'desc')
                                ->first();
                            if ( !empty ($res)) {
                                $data ['code'] = $res->code + 1;
                            } else {
                                $data ['code'] = $data ['fid'] + 1;
                            }
                        } else {
                            return redirect()->back()->with('error', '添加失败!');
                        }
                    }
                }
                $data->save();
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', '修改失败!');
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
        $data = Navigation::findOrFail($id);
        if ($data) {
            return view('admin.nav.edit', [
                'data' => $data,
            ]);
        }
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
        $result = Navigation::where('id', $id)->update([
            'name'       => $request->get('name'),
            'url'        => $request->get('url'),
            'permission' => $request->get('permission'),
            'rank'       => $request->get('rank'),
            'icon'       => $request->get('icon'),
        ]);
        if ( !$result) {
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
        $res = Navigation::findOrFail($id);
        $res2 = Navigation::where('fid', $res->code)->first();
        if ($res2) {
            return redirect()->back()->with('error', '此信息还是其他信息的父类,删除失败!');
        }
        $data = $res->delete();
        if ( !$data) {
            return redirect()->back()->with('error', '删除失败!');
        }

        return redirect()->back()->with('success', '删除成功!');
    }


    public function delete(Request $request)
    {
        $res = Navigation::findOrFail($request->get('id'));
        $res2 = Navigation::where('fid', $res->code)->first();
        if ($res2) {
            return redirect()->back()->with('error', '此信息还是其他信息的父类,删除失败!');
        }
        $data = $res->delete();
        if ( !$data) {
            return redirect()->back()->with('error', '删除失败!');
        }

        return redirect()->back()->with('success', '删除成功!');
    }


    public function findLists(Request $request)
    {
        if ($request->get('id') == 0) {
            $result = Navigation::where('fid', 0)->get();
        } else {
            $data = Navigation::where('id', $request->get('id'))->first(['code']);
            $result = Navigation::where('fid', $data->code)->get();
        }

        return $result;
    }
}
