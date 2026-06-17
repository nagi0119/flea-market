<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'image' => ['required', 'image', 'mimes:jpeg,png'],
            'categories' => ['required', 'array'],
            'categories.*' => ['exists:categories,id'],
            'item_condition' => ['required'],
            'name' => ['required'],
            'description' => ['required'],
            'price' => ['required', 'integer', 'min:1'],
        ];
    }

    public function messages()
    {
        return [
            'image.required' => '商品画像を選択してください',
            'categories.required' => 'カテゴリーを選択してください',
            'item_condition.required' => '商品の状態を選択してください',
            'name.required' => '商品名を入力してください',
            'description.required' => '商品説明を入力してください',
            'price.required' => '販売価格を入力してください',
        ];
    }
}
