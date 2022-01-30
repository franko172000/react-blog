<?php

namespace App\Http\Requests;

use App\Traits\FormRequestTrait;
use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
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
            'postId' => 'required|integer',
            'name' => 'required|string|min:2',
            'comment' => 'required|string|min:2'
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
            'postId.required' => 'Post ID is required',
            'name.required' => 'Name is required',
            'comment.required' => 'Comment is required'
        ];
    }
}
