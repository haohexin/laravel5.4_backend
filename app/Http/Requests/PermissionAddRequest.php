<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/24
 * Time: 13:59
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionAddRequest extends FormRequest {
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
            'name'         => 'required|unique:permissions,name',
            'display_name' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required'         => '权限必填',
            'name.unique'           => '权限不可重复添加',
            'display_name.required' => '权限名称必填',
        ];
    }
}