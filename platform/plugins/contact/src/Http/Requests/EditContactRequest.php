<?php

namespace Fast\Contact\Http\Requests;

use Fast\Contact\Enums\ContactStatusEnum;
use Fast\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class EditContactRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'status' => Rule::in(ContactStatusEnum::values()),
        ];
    }
}
