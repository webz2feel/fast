<?php

namespace Fast\Vendor\Http\Requests;

use Fast\Support\Http\Requests\Request;

class VendorChangeAvatarRequest extends Request
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
            'avatar' => 'required|image|mimes:jpg,jpeg,png',
        ];
    }
}
