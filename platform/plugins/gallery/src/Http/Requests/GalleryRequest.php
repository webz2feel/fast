<?php

namespace Fast\Gallery\Http\Requests;

use Fast\Support\Http\Requests\Request;

class GalleryRequest extends Request
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
            'description' => 'required|max:400',
            'order' => 'required|integer|min:0',
        ];
    }
}
