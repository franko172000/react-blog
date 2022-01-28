<?php

namespace App\Http\Requests;

use App\Traits\FormRequestTrait;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    use FormRequestTrait;

    protected $stopOnFirstFailure = true;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

     /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'firstName' => 'required|min:2',
            'lastName' => 'required|min:2',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'firstName.required' => 'First name is required',
            'firstName.min' => 'First must be a minimum of 2 characters',
            'lastName.required' => 'Last name is required',
            'lastName.min' => 'Last must be a minimum of 2 characters',
            'email.required' => 'Email field is required',
            'email.email' => 'A valid email address is required',
            'password.required' => 'Password is required'
        ];
    }
}
