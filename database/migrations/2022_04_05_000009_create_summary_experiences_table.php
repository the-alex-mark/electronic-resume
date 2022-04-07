<?php

use App\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSummaryExperiencesTable extends Migration {

    #region Properties

    /**
     * @inheritDoc
     */
    protected $table = 'summary_experiences';

    #endregion

    /**
     * @inheritDoc
     */
    public function up() {

        // Создание таблицы
        Schema::create($this->table, function (Blueprint $table) {
            $table->id();
            $table->foreignId('summary_id')->nullable(false)->comment('Резюме');
            $table->text('organization')->nullable(false)->comment('Организация');
            $table->timestamp('start')->nullable(false)->comment('Начало работы');
            $table->timestamp('end')->nullable()->comment('Окончание работы');
            $table->text('position')->nullable(false)->comment('Должность');
            $table->longText('description')->nullable(false)->comment('Обязанности на рабочем месте');
            $table->text('site')->nullable()->comment('Сайт');
        });

        // Установка внешних зависимостей
        Schema::table($this->table, function (Blueprint $table) {
            $table->foreign('summary_id')->references('id')->on('summaries')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * @inheritDoc
     */
    public function down() {

        // Удаление внешних зависимостей
        Schema::table($this->table, function (Blueprint $table) {
            $table->dropForeign($this->getForeignByColumnName('summary_id'));
        });

        // Удаление таблицы
        Schema::dropIfExists($this->table);
    }
}
