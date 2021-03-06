<?php

namespace Fast\RealEstate\Http\Requests;

use Fast\Support\Http\Requests\Request;

class FeatureRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => trans('plugins/real-estate::feature.messages.request.name_required'),
        ];
    }
}
