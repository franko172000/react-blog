<?php

namespace App\Traits;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;

trait ResponseTrait
{
    private array $stackTrace = [];

    public function setStackTrace(array $trace)
    {
        $this->stackTrace = $trace;
    }

    /**
     * @param string $message
     * @param array $data
     * @return JsonResponse
     */
    public function responseOk(string $message = "OK", array $data = []): JsonResponse
    {
        return $this->formatResponse(200, $message, $data);
    }

    /**
     * @param string $message
     * @param array $data
     * @return JsonResponse
     */
    public function responseCreated(string $message, array $data = []): JsonResponse
    {
        return $this->formatResponse(201, $message, $data);
    }

    /**
     * @param string $message
     * @param mixed $errors
     * @param string|null $errorCode
     * @return JsonResponse
     */
    public function responseNotFound(string $message, $errors = [], ?string $errorCode = null): JsonResponse
    {
        $errorCode = $errorCode ?? $this->getErrorCode('NOT_FOUND');
        return $this->formatResponse(404, $message, $errors, $errorCode);
    }

    /**
     * @param string $message
     * @param mixed $errors
     * @param string|null $errorCode
     * @return JsonResponse
     */
    public function responseConflict(string $message, $errors = [], ?string $errorCode = null): JsonResponse
    {
        $errorCode = $errorCode ?? $this->getErrorCode('CONFLICT');
        return $this->formatResponse(409, $message, $errors, $errorCode);
    }

    /**
     * @param string $message
     * @param mixed $errors
     * @param string|null $errorCode
     * @return JsonResponse
     */
    public function responseBadRequest(string $message, $errors = [], ?string $errorCode = null): JsonResponse
    {
        $errorCode = $errorCode ?? $this->getErrorCode('BAD_REQUEST');
        return $this->formatResponse(400, $message, $errors, $errorCode);
    }

    /**
     * @param Validator $validator
     * @return JsonResponse
     */
    public function responseValidation(Validator $validator): JsonResponse
    {
        $errorsMsg = $validator->errors()->getMessages();
        $errors = [];
        foreach ($errorsMsg as $val) {
            foreach ($val as $v) {
                $errors[] = $v;
            }
        }
        $errorCode = $this->getErrorCode('VALIDATION');
        return $this->formatResponse(422, "Your request could not be processed", [], $errors, $errorCode);
    }

    /**
     * @param string $message
     * @param mixed $errors
     * @param string|null $errorCode
     * @return JsonResponse
     */
    public function responseUnauthorized(string $message, $errors = [], ?string $errorCode = null): JsonResponse
    {
        $errorCode = $errorCode ?? $this->getErrorCode('UNAUTHORIZED');
        return $this->formatResponse(401, $message, [], $errors, $errorCode);
    }

    /**
     * @param string $message
     * @param mixed $errors
     * @param string|null $errorCode
     * @return JsonResponse
     */
    public function responseServerError(string $message, $errors = [], ?string $errorCode = null): JsonResponse
    {
        $errorCode = $errorCode ?? $this->getErrorCode('SERVER');
        return $this->formatResponse(500, $message, [], $errors, $errorCode);
    }

    /**
     * @param int $statusCode
     * @param string $message
     * @param mixed $errors
     * @param string|null $errorCode
     * @return JsonResponse
     */
    public function responseGeneral(
        int $statusCode,
        string $message,
        $errors = [],
        ?string $errorCode = null
    ): JsonResponse {
        return $this->formatResponse($statusCode, $message, [], $errors, $errorCode);
    }

    /**
     * @param int $statusCode
     * @param string $message
     * @param array $data
     * @param array $errors
     * @param string|null $errorCode
     * @return JsonResponse
     */
    private function formatResponse(
        int $statusCode,
        string $message,
        array $data = [],
        $errors = [],
        ?string $errorCode = null
    ): JsonResponse {
        $response = [
        'message' => $message,
        'statusCode' => $statusCode,
        ];

        if (count($data) > 0) {
            $response['data'] = $data;
        }

        if (is_array($errors) && count($errors) > 0) {
            $response['errors'] = $errors;
        }

        if (is_string($errors) && !empty($errors)) {
            $response['error'] = $errors;
        }

        if ($errorCode) {
            $response['errorCode'] = $errorCode;
        }
        if ($this->stackTrace) {
            $response['stackTrace'] = $this->stackTrace;
        }

        return response()->json($response, $statusCode);
    }

    /**
     * @param string $code
     * @return mixed
     */
    private function getErrorCode(string $code)
    {
        $config = config('system.error_codes');
        return $config[$code];
    }
}
