<?php

namespace Fast\Member\Http\Requests;

use Fast\Support\Http\Requests\Request;

class MemberEditRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => 'required|max:120|min:2',
            'email' => 'required|max:60|min:6|email|unique:members,email,' . $this->route('id'),
        ];

        if ($this->input('is_change_password') == 1) {
            $rules['password'] = 'required|min:6';
            $rules['password_confirmation'] = 'required|same:password';
        }

        return $rules;
    }
}
