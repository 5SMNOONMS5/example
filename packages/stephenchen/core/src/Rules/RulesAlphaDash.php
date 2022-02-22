<?php

namespace Stephenchen\Core\Rules;

use InvalidArgumentException;
use Illuminate\Contracts\Validation\Rule;

/**
 * 透過 function chain 可自由來組成判斷邏輯
 * 自由選擇是否需要`數字` + `大寫英文` + `小寫英文` + `開頭是否是英文` + `下底線` + `橫線` + `字數長度`
 * 默認是全部都驗證也就是 一定要 `數字` + `大寫英文` + `小寫英文` + `開頭是否是英文` + `下底線` + `橫線` 都要包含
 */
final class RulesAlphaDash implements Rule
{
    /**
     * Determine if the uppercase validation rule passes.
     *
     * @var boolean
     */
    private bool $validateUppercase = TRUE;

    /**
     * Determine if the lowercase validation rule passes.
     *
     * @var boolean
     */
    private bool $validateLowercase = TRUE;

    /**
     * Determine if the numeric validation rule passes.
     *
     * @var boolean
     */
    private bool $validateNumeric = TRUE;

    /**
     * Determine if the alpha should at position beginning.
     *
     * @var bool
     */
    private bool $validateAlphaAtBeginning = TRUE;

    /**
     * Determine if the underline validation rule passes.
     *
     * @var bool
     */
    private bool $validateUnderline = TRUE;

    /**
     * Determine if the dash validation rule passes.
     *
     * @var bool
     */
    private bool $validateDash = TRUE;

    /**
     * Length between
     *
     * @var string
     */
    private ?string $validateLengthBetween = NULL;

    /**
     * Error message prefix
     *
     * @var string
     */
    private ?string $errorMessagePrefix = NULL;

    /**
     * @var string
     */
    private ?string $validateLengthBetweenErrorMessage;

    /**
     * Laravel build in dump and die method
     *
     * @return RulesAlphaDash
     */
    public function ddRules(): self
    {
        $rules = $this->buildingRules();
        dd($rules);
        return $this;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $pattern = $this->buildingRules();

//        dd($pattern);
        /**
         * 沒有英文開頭
         * ([a-zA-Z\d\-_]{6,10}$)
         *
         * 有長度限制
         * (^[A-Za-z])([a-zA-Z\d\-_]{6,10}$)
         *
         * 沒有長度限制
         * (^[A-Za-z])([a-zA-Z\d\-_]$)
         */
        return preg_match($pattern, $value);
    }

    /**
     * @return bool
     */
    public function isValidateLowercase(): bool
    {
        return $this->validateLowercase;
    }

    /**
     * @param bool $validateLowercase
     *
     * @return RulesAlphaDash
     */
    public function setValidateLowercase(bool $validateLowercase): self
    {
        $this->validateLowercase = $validateLowercase;
        return $this;
    }

    /**
     * @return bool
     */
    public function isValidateUppercase(): bool
    {
        return $this->validateUppercase;
    }

    /**
     * @param bool $validateUppercase
     *
     * @return RulesAlphaDash
     */
    public function setValidateUppercase(bool $validateUppercase): self
    {
        $this->validateUppercase = $validateUppercase;
        return $this;
    }

    /**
     * @return bool
     */
    public function isValidateDash(): bool
    {
        return $this->validateDash;
    }

    /**
     * @param bool $validateDash
     *
     * @return RulesAlphaDash
     */
    public function setValidateDash(bool $validateDash): self
    {
        $this->validateDash = $validateDash;
        return $this;
    }

    /**
     * @return bool
     */
    public function isValidateUnderline(): bool
    {
        return $this->validateUnderline;
    }

    /**
     * @param bool $validateUnderline
     *
     * @return RulesAlphaDash
     */
    public function setValidateUnderline(bool $validateUnderline): self
    {
        $this->validateUnderline = $validateUnderline;
        return $this;
    }

    /**
     * @return bool
     */
    public function isValidateNumeric(): bool
    {
        return $this->validateNumeric;
    }

    /**
     * @param bool $validateNumeric
     *
     * @return RulesAlphaDash
     */
    public function setValidateNumeric(bool $validateNumeric): self
    {
        $this->validateNumeric = $validateNumeric;
        return $this;
    }

    /**
     * @return bool
     */
    public function isValidateAlphaAtBeginning(): bool
    {
        return $this->validateAlphaAtBeginning;
    }

    /**
     * @param bool $validateAlphaAtBeginning
     *
     * @return RulesAlphaDash
     */
    public function setValidateAlphaAtBeginning(bool $validateAlphaAtBeginning): self
    {
        $this->validateAlphaAtBeginning = $validateAlphaAtBeginning;
        return $this;
    }

    /**
     * @return string
     */
    public function getValidateLengthBetween(): ?string
    {
        return $this->validateLengthBetween;
    }

    /**
     * @param int $min
     * @param int $max
     *
     * @return RulesAlphaDash
     * @throws InvalidArgumentException
     */
    public function setValidateLengthBetween(int $min, int $max): self
    {
        if ($min <= 0) {
            throw new InvalidArgumentException('min 必須大於等於 1');
        }

        /**
         * @TIP: 從這邊開始
         *
         * $min 跟 $max 都要各別減去 1 是因為我這邊採用兩個 group
         *
         * group 1 我有限定長度是 1 然後為了要讓 group2 + group1 要符合使用者給予的長度限制，所以要各別減去 1
         * ( group1 )( group2 )
         *
         * 以下面例子
         * (^[A-Za-z]{1,1})([a-zA-Z\d\-_]{0,4}$)
         *
         * ( group1 ) 只允許 1 位然後是大小寫英文開頭
         * ( group1 ) 允許 大小寫英文開頭，數字，下底線，橫槓，然後可允許 0 ~ 4 位
         */

        $validateMin = $min - 1;
        $validateMax = $max - 1;

        $this->validateLengthBetween             = "{$validateMin},{$validateMax}";
        $this->validateLengthBetweenErrorMessage = "{$min},{$max}";

        return $this;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        $pattern = '只允許';

        if ($this->isValidateLowercase()) {
            $pattern = "{$pattern} 小寫英文";
        }
        if ($this->isValidateUppercase()) {
            $pattern = "{$pattern} 大寫英文";
        }
        if ($this->isValidateNumeric()) {
            $pattern = "{$pattern} 數字";
        }
        if ($this->isValidateDash()) {
            $pattern = "{$pattern} dash";
        }
        if ($this->isValidateUnderline()) {
            $pattern = "{$pattern} 下底線";
        }
        if ($this->isValidateAlphaAtBeginning()) {
            $pattern = "{$pattern} 英文字母開頭";
        }
        if ($this->getValidateLengthBetween()) {
            $pattern = "{$pattern} 長度只能限制是 {$this->validateLengthBetweenErrorMessage}";
        }

        return "{$this->errorMessagePrefix} {$pattern} 的組合";
    }

    /**
     * @return string
     */
    public function getErrorMessagePrefix(): ?string
    {
        return $this->errorMessagePrefix;
    }

    /**
     * @param string $errorMessagePrefix
     *
     * @return RulesAlphaDash
     */
    public function setErrorMessagePrefix(string $errorMessagePrefix): self
    {
        $this->errorMessagePrefix = $errorMessagePrefix;
        return $this;
    }

    /**
     * @return string
     */
    private function buildingRules(): string
    {
        $pattern = '';

        if ($this->isValidateLowercase()) {
            $pattern .= 'a-z';
        }
        if ($this->isValidateUppercase()) {
            $pattern .= 'A-Z';
        }
        if ($this->isValidateNumeric()) {
            $pattern .= '\d';
        }
        if ($this->isValidateDash()) {
            $pattern .= "\-";
        }
        if ($this->isValidateUnderline()) {
            $pattern .= "_";
        }

        // 這邊要記得把用 () 包起來判斷，group
        if ($this->getValidateLengthBetween()) {
            $pattern = "([$pattern]{{$this->validateLengthBetween}}$)";
        } else {
            $pattern = "([$pattern]+$)";
        }

        if ($this->isValidateAlphaAtBeginning()) {
            $pattern = "(^[A-Za-z]{1,1}){$pattern}";
        }

        $pattern = "/$pattern/";
        return $pattern;
    }
}
