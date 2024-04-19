<?php

namespace App\Http\Requests;

use App\Rules\PostCodeFields;
use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:191'],
            'post_code' => ['required', new PostCodeFields],
            'address' => ['required', 'string', 'max:191'],
            'building' => ['nullable', 'string', 'max:191'],
            'img' => ['nullable', 'image', 'max:5000'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '名前を入力してください',
            'name.string' => '名前を文字列で入力してください',
            'name.max' => '名前を191文字以内で入力してください',
            'post_code.required' => '郵便番号を入力してください',
            'address.required' => '住所を入力してください',
            'address.string' => '住所を文字列で入力してください',
            'address.max' => '住所を191文字以内で入力してください',
            'building.string' => '建物名を文字列で入力してください',
            'building.max' => '建物名を191文字以内で入力してください',
            'img.image' => '画像ファイルを選択してください',
            'img.max' => '画像は5MB以下を選択してください'
        ];
    }
}
