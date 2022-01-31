<?php

namespace App\Http\Requests;

use App\Traits\FormRequestTrait;
use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
            'title' => 'required|string|min:2',
            'description' => 'required|string|min:2',
            'category' => 'required|integer'
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
            'title.required' => 'Title is required',
            'title.min' => 'Title must have at least 2 characters',
            'title.string' => 'Title must be a string',
            'description.required' => 'Description is required',
            'description.min' => 'Description must have at least 2 characters',
            'description.string' => 'Description must be a string',
            'category.required' => 'Category is required',
            'category.integer' => 'Category must be a number',
        ];
    }
}
