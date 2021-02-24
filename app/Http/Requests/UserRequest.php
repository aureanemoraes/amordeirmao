<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{

    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'cpf' => ['required', 'size:11', Rule::unique('users')->ignore($this->id), 'cpf'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($this->id)],
            'quality_id' => 'required|integer',
            'password' => 'required'
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
