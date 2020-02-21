<?php

namespace Fast\Block\Http\Requests;

use Fast\Support\Http\Requests\Request;

class BlockRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * @author Imran Ali
     */
    public function rules()
    {
        return [
            'name' => 'required|max:120',
            'alias' => 'required|max:120',
        ];
    }
}
