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
        $email       = ['key' => 'email'];
        $displayName = ['key' => trans('core::global.display_name')];
        $account     = ['key' => trans('core::global.account')];
        $roleID      = ['key' => trans('core::global.role')];

        $messages = [
            'email.required' => trans('core::global.validation.required', $email),
            'email.email'    => trans('core::global.validation.email', $email),
            'email.unique'   => trans('core::global.validation.unique', $email),

            'display_name.required' => trans('core::global.validation.required', $displayName),

            'account.required' => trans('core::global.validation.required', $account),
            'account.unique'   => trans('core::global.validation.unique', $account),

            'role_id.required' => trans('core::global.validation.required', $roleID),
        ];

        $messages = array_merge($messages, $this->getPasswordValidationFailMessage($this->isPostMethod()));
        $messages = array_merge($messages, $this->getPasswordConfirmationValidationFailMessage());

        return $messages;
    }
}
