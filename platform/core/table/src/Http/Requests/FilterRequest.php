<?php

namespace Fast\Table\Http\Requests;

use Fast\Support\Http\Requests\Request;

class FilterRequest extends Request
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'class' => 'required',
        ];
    }
}
