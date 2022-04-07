<?php

use App\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSummariesTable extends Migration {

    #region Properties

    /**
     * @inheritDoc
     */
    protected $table = 'summaries';

    #endregion

    /**
     * @inheritDoc
     */
    public function up() {

        // Создание таблицы
        Schema::create($this->table, function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable(false)->comment('Пользователь');
            $table->foreignId('position_id')->nullable(false)->comment('Должность');
            $table->string('last_name', 255)->nullable(false)->comment('Фамилия');
            $table->string('first_name', 255)->nullable(false)->comment('Имя');
            $table->string('patronymic', 255)->nullable()->comment('Отчество');
            $table->timestamp('date_of_birth')->nullable(false)->comment('Дата рождения');
            $table->string('city', 255)->nullable(false)->comment('Город проживания');
            $table->enum('floor', [ 'male', 'women' ])->nullable(false)->comment('Пол');
            $table->text('phone')->nullable(false)->comment('Мобильный телефон');
            $table->text('email')->nullable()->comment('Электронная почта');
            $table->text('site')->nullable()->comment('Сайт');
            $table->longText('about')->nullable()->comment('Биография');

            // Добавление временных меток
            $table->timestamps();
        });

        // Установка внешних зависимостей
        Schema::table($this->table, function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('position_id')->references('id')->on('positions')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });

        // Индексация полей
        Schema::table($this->table, function (Blueprint $table) {
            $table->index('last_name');
            $table->index('first_name');
            $table->index('patronymic');
        });
    }

    /**
     * @inheritDoc
     */
    public function down() {

        // Удаление внешних зависимостей
        Schema::table($this->table, function (Blueprint $table) {
            $table->dropForeign($this->getForeignByColumnName('user_id'));
            $table->dropForeign($this->getForeignByColumnName('position_id'));
        });

        // Удаление индексации полей
        Schema::table($this->table, function (Blueprint $table) {
            $table->dropIndex($this->getIndexByColumnName('last_name'));
            $table->dropIndex($this->getIndexByColumnName('first_name'));
            $table->dropIndex($this->getIndexByColumnName('patronymic'));
        });

        // Удаление таблицы
        Schema::dropIfExists($this->table);
    }
}
