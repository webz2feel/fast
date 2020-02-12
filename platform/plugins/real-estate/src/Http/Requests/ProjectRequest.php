<?php

namespace Fast\RealEstate\Http\Requests;

use Fast\RealEstate\Enums\ProjectStatusEnum;
use Fast\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class ProjectRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'         => 'required|max:120',
            'content'      => 'required',
            'number_block' => 'numeric|nullable',
            'number_floor' => 'numeric|nullable',
            'number_flat'  => 'numeric|nullable',
            'price_from'   => 'numeric|nullable',
            'price_to'     => 'numeric|nullable',
            'status'       => Rule::in(ProjectStatusEnum::values()),
        ];
    }
}
