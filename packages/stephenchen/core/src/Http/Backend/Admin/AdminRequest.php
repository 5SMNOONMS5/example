<?php

namespace Stephenchen\Core\Http\Backend\Admin;

use Illuminate\Validation\Rule;
use InvalidArgumentException;
use Stephenchen\Core\Base\BaseRequest;
use Stephenchen\Core\Rules\RulesAlphaDash;
use Stephenchen\Core\Traits\Request\RequestPasswordTrait;

final class AdminRequest extends BaseRequest
{
    use RequestPasswordTrait;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * @throws InvalidArgumentException
     */
    public function rules()
    {
        $id = $this->route('authUser');

        $rules = [
            'account'      => [
                'required',
                ( new RulesAlphaDash() )
                    ->setErrorMessagePrefix('帳號')
                    ->setValidateLengthBetween(4, 12)
                    ->setValidateUnderline(FALSE)
                    ->setValidateDash(FALSE),
                Rule::unique('admins', 'account')->ignore($id, 'id'),
            ],
            'email'        => [
                'required',
                'email',
                Rule::unique('admins')
                    ->ignore($id, 'id')
                    ->whereNull('deleted_at'),
            ],
            'display_name' => 'required',
            'status'       => [
                'required',
            ],
            'role_id'      => [
                'required',
            ],
        ];

        $rules = array_merge($rules, $this->getPasswordRules($this->isPostMethod()));
        $rules = array_merge($rules, $this->getPasswordConfirmationRules());

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        $messages = [
            'email.required' => '請輸入信箱',
            'email.email'    => '信箱格式有誤',
            'email.unique'   => '信箱 不可重複',

            'display_name.unique' => '請輸入名稱',

            'account.required' => '請輸入帳號',
            'account.unique'   => '帳號不可重複',

            'role_id.required' => '請選擇角色',
        ];

        $messages = array_merge($messages, $this->getPasswordValidationFailMessage($this->isPostMethod()));
        $messages = array_merge($messages, $this->getPasswordConfirmationValidationFailMessage());

        return $messages;
    }
}
