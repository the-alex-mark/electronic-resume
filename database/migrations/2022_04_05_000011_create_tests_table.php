<?php

use App\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestsTable extends Migration {

    #region Properties

    /**
     * @inheritDoc
     */
    protected $table = 'tests';

    #endregion

    /**
     * @inheritDoc
     */
    public function up() {

        // Создание таблицы
        Schema::create($this->table, function (Blueprint $table) {
            $table->id();
            $table->foreignId('position_id')->nullable(false)->comment('Должность');
            $table->text('title')->nullable(false)->comment('Название');
            $table->longText('data')->nullable(false)->comment('Параметры теста');

            // Добавление временных меток
            $table->timestamps();
        });

        // Установка внешних зависимостей
        Schema::table($this->table, function (Blueprint $table) {
            $table->foreign('position_id')->references('id')->on('positions')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * @inheritDoc
     */
    public function down() {

        // Удаление внешних зависимостей
        Schema::table($this->table, function (Blueprint $table) {
            $table->dropForeign($this->getForeignByColumnName('position_id'));
        });

        // Удаление таблицы
        Schema::dropIfExists($this->table);
    }
}
