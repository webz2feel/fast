<?php

namespace Fast\Page\Http\Requests;

use Fast\Base\Enums\BaseStatusEnum;
use Fast\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class PageRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'    => 'required|max:120',
            'content' => 'required',
            'slug'    => 'required|max:255',
            'status'  => Rule::in(BaseStatusEnum::values()),
        ];
    }
}
