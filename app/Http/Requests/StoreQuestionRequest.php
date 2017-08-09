<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuestionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // 授权是否进行验证
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
            // 验证规则
            'title' => 'required|min:6|max:196',
            'body' => 'required|min:26'
        ];
    }

    /**
     * 获取验证提示信息
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => '标题不能为空',
            'title.min' => '标题不能少于6个字符',
            'title.max' => '标题不能多于于196个字符',
            'body.required' => '内容不能为空',
            'body.min' => '内容不能少于26个字符',
        ];
    }
}
