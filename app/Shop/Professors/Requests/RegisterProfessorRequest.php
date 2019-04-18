<?php

namespace App\Shop\Professors\Requests;

use App\Shop\Base\BaseFormRequest;

class RegisterProfessorRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:professors',
            'password' => 'required|string|min:6|confirmed',
        ];
    }
}
