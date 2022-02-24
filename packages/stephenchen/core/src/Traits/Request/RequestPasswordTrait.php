<?php

namespace Stephenchen\Core\Traits\Request;

use InvalidArgumentException;
use Stephenchen\Core\Rules\RulesAlphaDash;

trait RequestPasswordTrait
{
    /**
     * 如果有需要驗證 `密碼` 的話就用 array_merge
     *
     * @param bool $isRequired
     * @return array
     * @throws InvalidArgumentException
     */
    private function getPasswordRules(bool $isRequired): array
    {
        return [
            'password' => [
                // In creation process which is method Post.
                // User may not update password if they don't want
                $isRequired ? 'required' : 'nullable',
                ( new RulesAlphaDash() )
                    ->setErrorMessagePrefix('密碼')
                    ->setValidateLengthBetween(6, 12),
            ],
        ];
    }

    /**
     * 如果有需要驗證 `確認密碼` 的話就用 array_merge
     *
     * @return array
     */
    private function getPasswordConfirmationRules(): array
    {
        return [
            'password_confirmation' => [
                'required_with_all:password',
                'same:password',
            ],
        ];
    }

    /**
     * 統一 `密碼` 驗證格式的錯誤訊息
     *
     * @param bool $isRequired
     * @return array
     * @throws InvalidArgumentException
     */
    private function getPasswordValidationFailMessage(bool $isRequired): array
    {
        return $isRequired ?
            [
                'password.required' => '請輸入密碼',
            ] : [];
    }

    /**
     * 統一 `確認密碼` 驗證格式的錯誤訊息
     *
     * @return array
     * @throws InvalidArgumentException
     */
    private function getPasswordConfirmationValidationFailMessage(): array
    {
        return [
            'password_confirmation.same'              => __('message.password_confirmation_same'),
            'password_confirmation.required_with_all' => __('message.password_confirmation_required'),
        ];
    }
}
