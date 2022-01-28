<?php
namespace App\Traits;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

trait FormRequestTrait {
    use ResponseTrait;
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->responseValidation($validator));
    }
}