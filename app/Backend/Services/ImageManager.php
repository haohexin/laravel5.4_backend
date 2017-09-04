<?php

namespace App\Backend\Services;


use Intervention\Image\Facades\Image;

class ImageManager {

    //上传图片
    public function uploadImage($img, $directory, $width, $height)
    {
        // 判断存储地址是否存在
        $dir = \Storage::disk('image')->exists("$directory");
        if ( !$dir) {
            \Storage::disk('image')->makeDirectory("$directory");
        }
        // 随机数
        $time = time() . str_random(2);
        // 保存图片
        $imageSuccess = Image::make("$img")->resize("$width", "$height")->save("image/{$directory}/{$time}.jpg");
        if ( !$imageSuccess) {
            return $this->response->error("提交失败！", 403);
        }
        $url = "image/{$directory}/{$time}.jpg";

        return $url;
    }

}