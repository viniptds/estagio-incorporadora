<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreAdmin extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name"              => 'required|string',
            "email"             => 'required|string',
            "cpf"               => 'required|string|max:11',
            "phone"             => 'required|string',
            "password"          => 'required|string',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {

        if ($validator->fails()) {
            throw new HttpResponseException(response()->json([
                'msg'   => 'Ops! Algum campo obrigatório não foi preenchido.',
                'status' => false,
                'errors'    => $validator->errors(),
                'url'    => route('users.store')
            ], 403));
       }
    }
}
