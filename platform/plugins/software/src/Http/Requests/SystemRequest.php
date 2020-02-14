<?php

namespace Fast\Software\Http\Requests;

use Fast\Base\Enums\BaseStatusEnum;
use Fast\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class SystemRequest extends Request
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
            'name'        => 'required|max:120',
            'slug'        => 'required|max:120',
            'description' => 'max:400',
            'status'      => Rule::in(BaseStatusEnum::values()),
        ];
    }
}
