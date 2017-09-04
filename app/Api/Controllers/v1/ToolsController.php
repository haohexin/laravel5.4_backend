<?php

namespace App\Api\Controllers\v1;


use App\Api\Controllers\BaseController;
use App\Backend\Services\ImageManager;
use Illuminate\Http\Request;

class ToolsController extends BaseController {

    //  上传图片案例
    public function uploadImg(Request $request)
    {
        $image = new ImageManager();
        $data = [];
        //  add
        $data['img'] = $request->file('img') ? ($image->uploadImage($request->file('img'), 'test', 100, 100)) : '';
        //  edit
        $request->file('img') ? $data['img'] = ($image->uploadImage($request->file('img'), 'test', 100, 100)) : '';
        dd($data);
    }


}