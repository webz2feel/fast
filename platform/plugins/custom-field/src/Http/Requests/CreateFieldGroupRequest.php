<?php

namespace Fast\CustomField\Http\Requests;

use Fast\Support\Http\Requests\Request;

class CreateFieldGroupRequest extends Request
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
            'order' => 'integer|min:0|required',
            'rules' => 'json|required',
            'title' => 'required|max:255',
            'status' => 'required',
        ];
    }
}
