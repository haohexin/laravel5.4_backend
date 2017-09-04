<?php

namespace App\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;


class Admin extends Authenticatable {
    use EntrustUserTrait;

    protected $fillable = [
        'account', 'remember_token', 'password',
    ];


    public function roles()
    {
        return $this->belongsToMany('App\Model\Role', 'role_user', 'user_id', 'role_id');
    }
}
