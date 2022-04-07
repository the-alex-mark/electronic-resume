<?php

use App\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration {

    #region Properties

    /**
     * @inheritDoc
     */
    protected $table = 'users';

    #endregion

    /**
     * @inheritDoc
     */
    public function up() {

        // Создание таблицы
        Schema::create($this->table, function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->nullable(false)->comment('Роль');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        // Установка внешних зависимостей
        Schema::table($this->table, function (Blueprint $table) {
            $table->foreign('role_id')->references('id')->on('roles')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * @inheritDoc
     */
    public function down() {

        // Удаление внешних зависимостей
        Schema::table($this->table, function (Blueprint $table) {
            $table->dropForeign($this->getForeignByColumnName('role_id'));
        });

        // Удаление таблицы
        Schema::dropIfExists($this->table);
    }
}
