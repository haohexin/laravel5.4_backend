<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/24
 * Time: 13:59
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleAddRequest extends FormRequest {
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
            'name'         => 'required|unique:roles,name',
            'display_name' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required'         => '角色必填',
            'name.unique'           => '角色不可重复添加',
            'display_name.required' => '角色名称必填',
        ];
    }
}