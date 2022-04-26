<?php

if (!function_exists('phone_cleared')) {

    /**
     * Очищает номер телефона.
     *
     * @param  string $phone Номер телефона.
     * @return string
     */
    function phone_cleared($phone) {
        $cleared = preg_replace('/[^0-9]/', '', $phone);
        $cleared = substr($cleared, -10);

        return $cleared;
    }
}

if (!function_exists('phone_formatted')) {

    /**
     * Форматирует номер телефона.
     *
     * @param  string $phone   Номер телефона.
     * @param  bool   $convert Требуется ли преобразовывать номер с буквами в эквивалентные их числа?
     * @param  bool   $trim    Требуется ли обрезать номер до 11 символов?
     * @return string
     */
    function phone_formatted($phone, $convert = false, $trim = true) {

        // Возврат пустой строки при отсутствии номера
        if (empty($phone)) return '';

        // Удаление лишних символов
        $phone = preg_replace('/[^0-9A-Za-z]/', '', $phone);

        // Преобразование номера телефона с буквами в эквивалентные их числа
        // Пример: "1-800-TERMINIX", "1-800-FLOWERS", "1-800-Petmeds"
        if ($convert == true) {
            $replace = array(
                '2' => array( 'a','b','c' ),
                '3' => array( 'd','e','f' ),
                '4' => array( 'g','h','i' ),
                '5' => array( 'j','k','l' ),
                '6' => array( 'm','n','o' ),
                '7' => array( 'p','q','r','s' ),
                '8' => array( 't','u','v' ),
                '9' => array( 'w','x','y','z' )
            );

            // Замена букв без учёта регистра
            foreach($replace as $digit => $letters)
                $phone = str_ireplace($letters, $digit, $phone);
        }

        // Ограничение номера по количеству символов
        if ($trim == true && strlen($phone) > 11)
            $phone = substr($phone, 0, 11);

        // Форматирование номера
        switch (strlen($phone)) {

            case 6:
                return preg_replace('/([0-9a-zA-Z]{2})([0-9a-zA-Z]{2})([0-9a-zA-Z]{2})/', '$1-$2-$3', $phone);

            case 7:
                return preg_replace("/([0-9a-zA-Z]{3})([0-9a-zA-Z]{4})/", "$1-$2", $phone);

            case 10:
            case 11:
                return preg_replace('/([0-9a-zA-Z]{3})([0-9a-zA-Z]{3})([0-9a-zA-Z]{2})([0-9a-zA-Z]{2})/', '+7 ($1) $2-$3-$4', (strlen($phone) == 11)
                    ? substr($phone, 1, strlen($phone))
                    : $phone);

            // Возврат оригинального значение при невыполнении всех условий
            default:
                return $phone;
        }
    }
}

if (!function_exists('phone_masked')) {

    /**
     * Форматирует и маскирует номер мобильного телефона.
     * <br><br>
     * <b>Примечание:</b>
     * <br>
     * Метод маскирует только номер с длиной равной 11 символов (цифр).</b>
     *
     * @param  string $phone   Номер мобильного телефона.
     * @param  string $pattern Маскировочный символ.
     * @return string
     */
    function phone_masked($phone, $pattern = '*') {
        $pattern = mb_substr($pattern, 0, 1);
        $phone   = phone_formatted($phone, true);
        $phone   = (strlen($phone) == 18)
            ? mb_substr($phone, 0, 9) . str_repeat($pattern, 3) . '-' . str_repeat($pattern, 2) . mb_substr($phone, -3, 3)
            : $phone;

        return $phone;
    }
}
