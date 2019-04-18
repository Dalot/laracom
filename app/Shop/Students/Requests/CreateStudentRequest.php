<?php

namespace App\Shop\Students\Requests;

use App\Shop\Base\BaseFormRequest;

class CreateStudentRequest extends BaseFormRequest
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
            'email' => ['required', 'email', 'unique:students'],

        ];
    }
}
