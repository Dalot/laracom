<?php

namespace App\Shop\Schools\Requests;

use App\Shop\Base\BaseFormRequest;

class CreateSchoolRequest extends BaseFormRequest
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
            'email' => ['required', 'email', 'unique:schools'],
            'password' => ['required', 'min:8']
        ];
    }
}
