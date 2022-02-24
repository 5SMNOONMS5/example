<?php

namespace Stephenchen\Core\Base;

use Stephenchen\Core\Service\Response\ResponseObject;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

abstract class BaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Use middleware instead
        return TRUE;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    abstract public function rules();

    /**
     * Return custom error format for backward compatible
     *
     * @param Validator $validator
     *
     * @throws ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        /*
         * Custom return format
         * {
         *      code: 400,
         *      msg: [
         *          'error message 1',
         *          'error message 2',
         *          'error message 3',
         *      ]
         * }
         */


        // @TODO: 先暫時這樣 不判斷是不是從 api 來的
        $errors   = ( new ValidationException($validator) )->errors();
        $message  = collect($errors)->flatten()->first();
        $response = ResponseObject::fail($message, 422);

        throw new HttpResponseException(
            $response,
        );

        if ($this->wantsJson()) {
            $errors   = ( new ValidationException($validator) )->errors();
            $message  = collect($errors)->flatten()->first();
            $response = ResponseObject::fail($message, 422);

            throw new HttpResponseException(
                $response
            );
        }

        $this->failedValidation($validator);
    }

    /**
     * Return true if http method is post
     */
    protected function isPostMethod(): bool
    {
        return $this->getMethod() === self::METHOD_POST;
    }

    /**
     * Return true if http method is put
     */
    protected function isPutMethod(): bool
    {
        return $this->getMethod() === self::METHOD_PUT;
    }
}


