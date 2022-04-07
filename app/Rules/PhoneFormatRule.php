<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * Проверяет формат номера телефона.
 */
class PhoneFormatRule implements Rule {

    /**
     * Проверяет номер телефона на соответствие с форматом "<b>+7 (000) 000-00-00</b>".
     *
     * @param  string $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value) {
        return preg_match('/^((\+7)|(8))(\s\()(\d{3})(\)\s)((\d{3})-(\d{2})-(\d{2}))$/', $value);
    }

    /**
     * @inheritDoc
     */
    public function message() {
        return 'Недействительный номер мобильного телефона.';
    }
}

