<?php

namespace Fast\Member\Http\Requests;

use Fast\Support\Http\Requests\Request;

class EditAccountRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'phone' => 'required|max:20',
            'dob' => 'date|max:20',
        ];
    }
}
