<?php

namespace Stephenchen\Core\Traits;

use Stephenchen\Core\Rules\RulesAlphaDash;
use InvalidArgumentException;

trait PasswordTrait
{
    /**
     * Unified password rules
     *
     * @param bool $isRequired
     *
     * @return array
     * @throws InvalidArgumentException
     */
    private function getPasswordRules(bool $isRequired): array
    {
        return [
            // In creation process which is method Post.
            // User may not update password if they don't want
            $isRequired ? 'required' : 'nullable',
            ( new RulesAlphaDash() )
                ->setErrorMessagePrefix('密碼')
                ->setValidateLengthBetween(6, 12),
        ];
    }
}
