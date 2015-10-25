<?php

namespace Portphilio\Http\Requests;

class RegistrationRequest extends Request
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
        $rules = [
            'username' => ['required', 'unique:users,username', 'regex:/^[\w]{3,}$/'],
            'first_name' => ['required'],
            'last_name' => ['required'],
            'email' => ['required', 'email', 'unique:users,email', 'confirmed'],
            'password' => ['required', 'confirmed', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[\d])(?=.*[^\w\n])[^\n]{11,}$/'],
        ];
        if ('acceptance' != env('APP_ENV')) {
            $rules['g-recaptcha-response'] = ['required', 'recaptcha'];
        }

        return $rules;
    }

    /**
     * Customize the error messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'username.regex' => 'The username must be three or more alphanumeric characters long.',
            'password.regex' => 'The password must be 11 or more characters and have at least one upper, lower, digit, and special character.',
        ];
    }
}
