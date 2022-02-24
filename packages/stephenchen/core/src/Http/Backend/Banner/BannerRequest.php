<?php

namespace Stephenchen\Core\Http\Backend\Banner;

use Stephenchen\Core\Base\BaseRequest;

final class BannerRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'    => 'required',
            'subtitle' => 'required',
            'synopsis' => 'required',
            // Add more ....
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
            'title.required'    => '請輸入 title',
            'subtitle.required' => '請輸入 subtitle',
            'synopsis.required' => '請輸入 synopsis',
            // Add more ....
        ];
    }
}
