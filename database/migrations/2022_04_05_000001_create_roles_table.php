<?php

use App\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration {

    #region Properties

    /**
     * @inheritDoc
     */
    protected $table = 'roles';

    #endregion

    /**
     * @inheritDoc
     */
    public function up() {

        // Создание таблицы
        Schema::create($this->table, function (Blueprint $table) {
            $table->id();
            $table->string('slug', 255)->unique()->nullable(false)->comment('Ярлык');
            $table->text('title')->nullable(false)->comment('Название');
        });
    }

    /**
     * @inheritDoc
     */
    public function down() {

        // Удаление таблицы
        Schema::dropIfExists($this->table);
    }
}
