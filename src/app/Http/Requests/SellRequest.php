<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SellRequest extends FormRequest
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
            'img' => ['required', 'image', 'max:10000'],
            'category_id' => ['required', 'array'],
            'category_id.*' => ['numeric'],
            'status_id' => ['required', 'numeric', 'between:1,4'],
            'name' => ['required', 'string', 'max:191'],
            'brand' => ['nullable', 'string', 'max:191'],
            'price' => ['required', 'numeric'],
            'description' => ['required', 'string', 'max:200'],
        ];
    }

}
