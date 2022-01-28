<?php

namespace App\Http\Requests;

use App\Traits\FormRequestTrait;
use App\Traits\ResponseTrait;
use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
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
            'email' => 'required | email',
            'password' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Email not set',
            'password.required' => 'Password not set'
        ];
    }
}
