<?php

namespace Stephenchen\Core\Http\Backend\Permission;

use Illuminate\Validation\Rule;
use InvalidArgumentException;
use Stephenchen\Core\Base\BaseRequest;
use Stephenchen\Core\Traits\PasswordTrait;

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
        $id = $this->route('id');

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
        return [
            'name.required' => '請輸入 權限名稱',
            'name.unique'   => '權限名稱 不可重複',
        ];
    }
}
