<?php

namespace Stephenchen\Core\Http\Backend\Admin;

use Stephenchen\Core\Base\BaseRequest;
use Stephenchen\Core\Rules\RulesAlphaDash;
use Stephenchen\Core\Traits\PasswordTrait;
use Illuminate\Validation\Rule;
use InvalidArgumentException;

final class AdminRequest extends BaseRequest
{
    use PasswordTrait;

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
            'permission_group' => [
                'nullable',
            ],
            'email'            => [
                'required',
                'email',
                Rule::unique('admins')
                    ->ignore($id, 'id')
                    ->whereNull('deleted_at'),
            ],
            'account'          => [
                'required',
                ( new RulesAlphaDash() )
                    ->setErrorMessagePrefix('帳號')
                    ->setValidateLengthBetween(4, 12)
                    ->setValidateUnderline(FALSE)
                    ->setValidateDash(FALSE),
                Rule::unique('admins', 'account')->ignore($id),
            ],
            'password'         => $this->getPasswordRules($this->isPostMethod()),
            'display_name'     => 'required',
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
            'email.required' => '請輸入信箱',
            'email.email'    => '信箱格式有誤',
            'email.unique'   => '信箱 不可重複',

            'display_name.unique' => '請輸入名稱',

            'account.required' => '請輸入帳號',
            'account.unique'   => '帳號不可重複',
            'account.between'  => '帳號必須在 4 ~ 12 中英混合',

            'password.required' => '請輸入密碼',
            'password.unique'   => '密碼不可重複',
            'password.between'  => '密碼必須在 6 ~ 12 中英混合',

            'permission_group.required' => '請選擇權限',
        ];
    }
}
