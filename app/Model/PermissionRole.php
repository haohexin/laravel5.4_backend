<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/24
 * Time: 17:10
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PermissionRole extends Model {
    public    $timestamps = false;
    protected $table      = 'permission_role';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'permission_id',
        'role_id',
    ];

    public function permission()
    {
        return $this->hasOne('App\Model\Permission', 'id', 'permission_id');
    }
}