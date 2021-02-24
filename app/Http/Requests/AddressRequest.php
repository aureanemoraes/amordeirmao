<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
{
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    public function rules()
    {
        return [
            'zip_code' => 'max:8',
            'public_place' => 'required|max:255',
            'number' => 'required|max:10',
            'neighborhood' => 'required|max:255',
            'reference_place' => 'max:255',
            'uf' => 'required|max:2',
        ];
    }

    public function attributes()
    {
        return [
            //
        ];
    }

    public function messages()
    {
        return [
            //
        ];
    }
}
