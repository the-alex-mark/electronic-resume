<?php

use App\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSummaryEducationsTable extends Migration {

    #region Properties

    /**
     * @inheritDoc
     */
    protected $table = 'summary_educations';

    #endregion

    /**
     * @inheritDoc
     */
    public function up() {

        // Создание таблицы
        Schema::create($this->table, function (Blueprint $table) {
            $table->id();
            $table->foreignId('summary_id')->nullable(false)->comment('Резюме');
            $table->text('institution')->nullable(false)->comment('Учебное заведение');
            $table->text('faculty')->nullable()->comment('Факультет');
            $table->text('specialization')->nullable()->comment('Специализация');
            $table->year('year')->nullable(false)->comment('Год окончания');
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
