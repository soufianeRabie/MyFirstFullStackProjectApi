<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            "title" => ["bail", "min:6", "max:50"],
            "description" => ["bail", "min:10", "required"],
            "rating" => ["bail", "required"],
            "price" => ["bail", "numeric", "required"],
            "oldPrice" => ["bail", "numeric"],
            "isSold" => ["bail", "required"],
        ];

        // Check if the request method is POST
        if ($this->isMethod('post')) {
            $rules["image.*"] = ["bail", "image", "mimes:jpg,jpeg,png,gif", "required"];
        } elseif ($this->isMethod('put')) {
            // check if the request method is PUT
            $rules["image.*"]=["bail","mimes:jpg,jpeg,png,gif"];
        }

        if ($this->boolean('isSold')) {
            $rules['oldPrice'][] = 'required';
            $rules['oldPrice'][] = 'gt:'.$this->input('price');
        }

        return $rules;
    }
}
