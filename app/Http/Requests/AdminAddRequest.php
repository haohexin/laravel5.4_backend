<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/24
 * Time: 13:59
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminAddRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'category' => 'required',
            'username' => 'required|unique:admins,account',
            'password' => 'required|min:6',
        ];
    }

    public function messages()
    {
        return [
            'category.required' => '类型必填',
            'username.required' => '姓名必填',
            'username.unique'   => '用户名不可重复',
            'password.required' => '密码必填',
            'password.min'      => '密码最短为6位',
        ];
    }
}