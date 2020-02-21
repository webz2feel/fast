<?php

namespace Fast\LogViewer\Http\Requests;

use Fast\Support\Http\Requests\Request;

class LogViewerRequest extends Request
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
            'name' => 'required',
        ];
    }
}
