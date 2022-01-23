<?php

namespace Stephenchen\Core\Http\Backend\Role;

use Stephenchen\Core\Base\BaseRequest;
use Illuminate\Validation\Rule;

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
            'title'       => 'required',
            'description' => 'required',
            'permissions' => 'required|array',
            Rule::unique('permissions', 'name')->ignore($id),
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
            'name.required'        => '請輸入 權限群組唯一值',
            'name.unique'          => '權限群組唯一值 不可重複',
            'title.required'       => '請輸入 標題',
            'description.required' => '請輸入 描敘',

            'permissions.required' => '請至少輸入一種權限',
            'permissions.array'    => '格式錯誤',
        ];
    }
}
