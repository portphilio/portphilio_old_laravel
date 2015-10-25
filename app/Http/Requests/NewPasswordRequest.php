<?php

namespace Portphilio\Http\Requests;

class NewPasswordRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => ['required'],
            'reset_code' => ['required'],
            'password' => ['required', 'confirmed', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[\d])(?=.*[^\w\n])[^\n]{11,}$/'],
        ];
    }

    /**
     * Customize the error messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'password.regex' => 'The password must be 11 or more characters and have at least one upper, lower, digit, and special character.',
        ];
    }
}
