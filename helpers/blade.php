<?php

if (!function_exists('__checked_selected_helper')) {

    /**
     * Вспомогательный метод для работы "checked", "selected", "disabled" и "readonly".
     * Сравнивает первые два аргумента, в случае идентичности отображает указанный html-атрибут.
     *
     * @access private
     *
     * @param  mixed  $helper  Первый аргумент сравнения.
     * @param  mixed  $current Второй аргумент сравнения.
     * @param  bool   $echo    Требуется ли вывод результата.
     * @param  string $type    Атрибут "checked", "selected", "disabled" или "readonly".
     * @return string
     */
    function __checked_selected_helper($helper, $current, $echo, $type) {
        $result = ((string)$helper === (string)$current)
            ? " $type='$type'"
            : '';

        if ($echo)
            echo $result;

        return $result;
    }
}

if (!function_exists('checked')) {

    /**
     * Отображает html-атрибут "checked".
     * Сравнивает первые два аргумента, в случае идентичности отображает html-атрибут "checked".
     *
     * @param  mixed $checked Первый аргумент сравнения.
     * @param  mixed $current Второй аргумент сравнения.
     * @return string
     */
    function checked($checked, $current = true) {
        return __checked_selected_helper($checked, $current, false, 'checked');
    }
}

if (!function_exists('selected')) {

    /**
     * Отображает html-атрибут "selected".
     * Сравнивает первые два аргумента, в случае идентичности отображает html-атрибут "selected".
     *
     * @param  mixed $selected Первый аргумент сравнения.
     * @param  mixed $current  Второй аргумент сравнения.
     * @return string
     */
    function selected($selected, $current = true) {
        return __checked_selected_helper($selected, $current, false, 'selected');
    }
}

if (!function_exists('disabled')) {

    /**
     * Отображает html-атрибут "disabled".
     * Сравнивает первые два аргумента, в случае идентичности отображает html-атрибут "disabled".
     *
     * @param  mixed $disabled Первый аргумент сравнения.
     * @param  mixed $current  Второй аргумент сравнения.
     * @return string
     */
    function disabled($disabled, $current = true) {
        return __checked_selected_helper($disabled, $current, false, 'disabled');
    }
}

if (!function_exists('readonly')) {

    /**
     * Отображает html-атрибут "readonly".
     * Сравнивает первые два аргумента, в случае идентичности отображает html-атрибут "readonly".
     *
     * @param  mixed $readonly Первый аргумент сравнения.
     * @param  mixed $current  Второй аргумент сравнения.
     * @return string
     */
    function readonly($readonly, $current = true) {
        return __checked_selected_helper($readonly, $current, false, 'readonly');
    }
}
