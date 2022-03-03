<?php

namespace Stephenchen\Banner\Http\Backend\Banner;

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
            'title'  => 'required',
            'path'   => 'required',
            'status' => 'required|numeric',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        $title  = ['key' => trans('core::global.title')];
        $path   = ['key' => trans('core::global.path')];
        $status = ['key' => 'status'];

        $name = ['key' => trans('core::global.permission')];

        return [
            'title.required'  => trans('core::global.validation.required', $title),
            'path.required'   => trans('core::global.validation.required', $path),
            'status.required' => trans('core::global.validation.required', $status),
            'status.numeric'  => trans('core::global.validation.numeric', $status),
        ];
    }
}
