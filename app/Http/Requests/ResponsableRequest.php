<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\Director;
use App\Models\Manager;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ResponsableRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => [
                'required',
                'integer',
                'unique:responsables',
                Rule::notIn(Manager::get()->pluck('user_id')->toArray()),
                Rule::notIn(Director::get()->pluck('user_id')->toArray()),
            ],
            'responsable_id' => 'required|integer'
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //
        ];
    }
}
