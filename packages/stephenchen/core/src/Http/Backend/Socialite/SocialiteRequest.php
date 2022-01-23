<?php

namespace Stephenchen\Core\Http\Backend\Socialite;

use Stephenchen\Core\Base\BaseRequest;

/**
 * Class SocialiteRequest
 *
 * @package App\Http\Backend\Socialite
 */
final class SocialiteRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [

        ];
    }
}
