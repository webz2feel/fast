<?php

namespace Fast\RealEstate\Http\Requests;

use Fast\RealEstate\Enums\PropertyStatusEnum;
use Fast\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class PropertyRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'    => 'required',
            'content' => 'required',
            'price'   => 'numeric|nullable',
            'status'  => Rule::in(PropertyStatusEnum::values()),
        ];
    }
}
