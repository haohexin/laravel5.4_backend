<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CategoryAddRequest;
use App\Http\Requests\IdRequest;
use App\Model\Dictionary;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Dictionary::where('level', '1')->orderBy('rank')->get();

        return view('admin.category.lists', [
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
        return view('admin.category.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CategoryAddRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryAddRequest $request)
    {
        $type = $request ['type'];
        $title = explode(',', $request ['title']);
        $intro = explode(',', $request ['intro']);
        $rank = explode(',', $request ['rank']);
        \DB::beginTransaction();
        try {
            foreach ($title as $k => $v) {
                if ($v) {
                    $data = new Dictionary();
                    $data ['name'] = $v;
                    $data ['intro'] = key_exists("$k", $intro) ? $intro[ $k ] : '';
                    $data ['rank'] = key_exists("$k", $rank) ? $rank[ $k ] : '';
                    if ($type == '1') {
                        $data ['level'] = 1;
                        $data ['fid'] = 0;
                        $res = Dictionary::where('fid', 0)->orderBy('code', 'desc')->first([
                            'code',
                        ]);

                        $data ['code'] = $res ? $res->code + 10000 : 10000;
                    } elseif ($type == '2') {
                        $data ['level'] = 2;
                        $province_id = $request ['province'];
                        if ($province_id != 0) {
                            $province = Dictionary::where('id', $province_id)->first([
                                'code',
                            ]);
                            $data ['fid'] = $province->code;
                            $res = Dictionary::where('fid', $province->code)->orderBy('code', 'desc')->first([
                                'code',
                            ]);
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
                            $city = Dictionary::where('id', $city_id)->first([
                                'code',
                            ]);
                            $data ['fid'] = $city->code;
                            $res = Dictionary::where('fid', $city->code)->orderBy('code', 'desc')->first([
                                'code',
                            ]);
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
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollBack();

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
        $data = Dictionary::findOrFail($id);
        if ($data) {
            return view('admin.category.edit', compact('data'));
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
        $data ['name'] = $request ['name'];
        $data ['intro'] = $request ['intro'];
        $data ['rank'] = $request ['rank'];
        $result = Dictionary::where('id', $id)->update($data);
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
        $res = Dictionary::findOrFail($id);
        $res2 = Dictionary::where('fid', $res->code)->first();
        if ($res2) {
            return redirect()->back()->with('error', '此信息还是其他信息的父类,删除失败!');
        }
        $data = Dictionary::where('id', $id)->delete();
        if ( !$data) {
            return redirect()->back()->with('error', '删除失败!');
        }

        return redirect()->back()->with('success', '删除成功!');
    }

    public function delete(IdRequest $request)
    {
        $res = Dictionary::findOrFail($request->get('id'));
        $res2 = Dictionary::where('fid', $res->code)->first();
        if ($res2) {
            return redirect()->back()->with('error', '此信息还是其他信息的父类,删除失败!');
        }
        $data = $res->delete();
        if ( !$data) {
            return redirect()->back()->with('error', '删除失败!');
        }

        return redirect()->back()->with('success', '删除成功!');
    }


    // 下级地址
    public function findLists(IdRequest $request)
    {
        return $this->getCategory($request ['id']);
    }

    private function getCategory($id)
    {
        if ($id == 0) {
            $result = Dictionary::where('fid', 0)->get();
        } else {
            $data = Dictionary::where('id', $id)->first(['code']);
            $result = Dictionary::where('fid', $data->code)->get();
        }

        return $result;
    }
}
