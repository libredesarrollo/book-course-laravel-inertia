<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class Put extends FormRequest
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
            "title" => "required|min:5|max:255",
            "slug" => "required|min:5|max:255|unique:categories,id," . $this->route('category')->id,
        ];
    }
    function prepareForValidation()
    {
        if (str($this->slug)->trim() == '') {
            $this->merge([
                'slug' => str($this->title)->slug()
            ]);
        }
    }
}
