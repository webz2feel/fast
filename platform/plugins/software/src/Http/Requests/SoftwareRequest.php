<?php

namespace Fast\Software\Http\Requests;

use Fast\Base\Enums\BaseStatusEnum;
use Fast\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class SoftwareRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'        => 'required|max:255',
            'description' => 'max:400',
            'categories'  => 'required',
            'slug'        => 'required|max:255',
            'status'      => Rule::in(BaseStatusEnum::values()),
        ];
    }
}
