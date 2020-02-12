<?php

namespace Fast\Career\Http\Requests;

use Fast\Base\Enums\BaseStatusEnum;
use Fast\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class CareerRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'        => 'required',
            'location'    => 'required',
            'salary'      => 'required',
            'description' => 'required',
            'status'      => Rule::in(BaseStatusEnum::values()),
        ];
    }
}
