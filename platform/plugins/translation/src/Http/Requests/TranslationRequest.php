<?php

namespace Fast\Translation\Http\Requests;

use Fast\Support\Http\Requests\Request;

class TranslationRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     *
     */
    public function rules()
    {
        return [
            'name' => 'required',
        ];
    }
}
