<?php

namespace Stephenchen\Core\Http\Backend\Role;

use Illuminate\Validation\Rule;
use Stephenchen\Core\Base\BaseRequest;

/**
 * Class RoleRequest
 *
 * @package App\Http\Backend\Role
 */
class RoleRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->route('id');

        return [
            'name'          => [
                'required',
                Rule::unique('roles', 'name')->ignore($id),
            ],
            'permission_ids' => 'array',
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
            'name.required' => '請輸入 權限群組唯一值',
            'name.unique'   => '權限群組唯一值 不可重複',
        ];
    }
}
