<?php

namespace App\Database\Eloquent\Concerns;

trait HasValidation {

    #region Abstracts

    /**
     * ...
     *
     * @return array
     */
    abstract static function validatorRules();

    /**
     * ...
     *
     * @return array
     */
    abstract static function validatorAttributes();

    #endregion

    #region Helpers

    /**
     * ...
     *
     * @param  string $prefix  Префикс ключа.
     * @param  array $array
     * @return array
     */
    protected static function addPrefixKeyOfArray($prefix = null, $array = []) {
        if (!empty($prefix) && !empty($array)) {
            $keys  = array_map(function($key) use ($prefix) { return $prefix . $key; }, array_keys($array));
            $array = array_combine($keys, $array);

            return $array;
        }

        return $array;
    }

    #endregion

    /**
     * ...
     *
     * @param  string Префикс ключа.
     * @return array
     */
    public static function getValidatorAttributes($prefix = null) {
        return self::addPrefixKeyOfArray(
            $prefix,
            self::validatorAttributes()
        );
    }

    /**
     * ...
     *
     * @param  string Префикс ключа.
     * @return array
     */
    public static function getValidatorRules($prefix = null) {
        return self::addPrefixKeyOfArray(
            $prefix,
            self::validatorRules()
        );
    }
}
