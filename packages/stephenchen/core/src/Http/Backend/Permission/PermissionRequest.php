<?php

namespace Stephenchen\Core\Http\Backend\Permission;

use Illuminate\Validation\Rule;
use InvalidArgumentException;
use Stephenchen\Core\Base\BaseRequest;

final class PermissionRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * @throws InvalidArgumentException
     */
    public function rules()
    {
        $id = $this->route('permission');

        return [
            'name' => [
                'required',
                Rule::unique('permissions', 'name')->ignore($id),
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        $name = ['key' => trans('core::global.permission')];

        return [
            'name.required' => trans('core::global.validation.required', $name),
            'name.unique'   => trans('core::global.validation.unique', $name),
        ];
    }
}
