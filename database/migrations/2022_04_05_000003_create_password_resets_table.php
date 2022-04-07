<?php

use App\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePasswordResetsTable extends Migration {

    #region Properties

    /**
     * @inheritDoc
     */
    protected $table = 'password_resets';

    #endregion

    /**
     * @inheritDoc
     */
    public function up() {

        // Создание таблицы
        Schema::create($this->table, function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
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
