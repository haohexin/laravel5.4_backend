<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Navigation extends Model {

    // 与二级菜单的关系
    public function secondLevel()
    {
        return $this->hasMany('App\Model\Navigation', 'fid', 'code');
    }
}
