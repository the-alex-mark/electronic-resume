<?php

namespace App\Database;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 *
 */
class Guard {

    /**
     * Отключает защиту БД.
     *
     * @return void
     */
    public static function unguard() {

        // Отключение проверки внешних ключей и очистка таблицы
        Schema::disableForeignKeyConstraints();

        // Отключение защиты массового присвоения
        Model::unguard();

        // Включение возможности установки нулевого идентификатора при выполнении запроса "INSERT"
        DB::statement('SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";');
    }

    /**
     * Возобновляет защиту БД.
     *
     * @return void
     */
    public static function reguard() {

        // Возобновление защиты
        Model::reguard();

        // Включение проверки внешних ключей
        Schema::enableForeignKeyConstraints();
    }
}
