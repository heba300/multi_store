<?php

namespace App\Http\Requests;

use App\Rules\Filter;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
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
        $id = $this->route('category');

        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
                Rule::unique('categories', 'name')->ignore($id),
                // function ($attribute, $value, $fails) {
                //     if (strtolower($value) == 'laravel') {
                //         $fails('this name is forbadden!');
                //     }
                // },
                new Filter(['php', 'laravel']),
            ],
            'pareint_id' => 'nullable|int|exists:categories,id',
            'image' => 'image|max:1048576|dimensions:min_width:100,mic_height=100',
            'stutas' => 'in:active,archived',
        ];
    }


    public function messages()
    {
        return [
            'name.unique' => 'this name is unique',
        ];
    }
}
