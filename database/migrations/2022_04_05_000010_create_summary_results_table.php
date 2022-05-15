<?php

use App\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSummaryResultsTable extends Migration {

    #region Properties

    /**
     * @inheritDoc
     */
    protected $table = 'summary_results';

    #endregion

    /**
     * @inheritDoc
     */
    public function up() {

        // Создание таблицы
        Schema::create($this->table, function (Blueprint $table) {
            $table->id();
            $table->foreignId('summary_id')->nullable(false)->comment('Резюме');
            $table->longText('questions')->nullable(false)->comment('Вопросы');
            $table->longText('answers')->nullable()->comment('Ответы');
            $table->timestamp('checked_at')->nullable()->comment('Дата проверки');

            // Добавление временных меток
            $table->timestamps();
        });

        // Установка внешних зависимостей
        Schema::table($this->table, function (Blueprint $table) {
            $table->foreign('summary_id')->references('id')->on('summaries')->onUpdate('CASCADE')->onDelete('RESTRICT');
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
