<?php

namespace App\Shop\Professors\Requests;

use App\Shop\Base\BaseFormRequest;

class CreateProfessorRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:professors'],
            'password' => ['required', 'min:8']
        ];
    }
}
