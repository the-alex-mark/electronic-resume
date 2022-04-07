<?php

namespace Database\Seeders;

use App\Database\Guard;
use App\Models\Position;
use App\Models\Role;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {

    #region Roles

    /**
     * Выполняет заполнение ролей пользователей.
     *
     * @return void
     */
    private function roles() {
        Role::query()->create([
            'slug'  => 'candidate',
            'title' => 'Кандидат'
        ]);

        Role::query()->create([
            'slug'  => 'head_of_the_department',
            'title' => 'Руководитель отдела'
        ]);

        Role::query()->create([
            'slug'  => 'hr',
            'title' => 'HR'
        ]);
    }

    /**
     * Выполняет заполнение должностей.
     *
     * @return void
     */
    private function positions() {
        Position::query()->create([
            'slug'  => 'engineer_programmer',
            'title' => 'Инженер-программист'
        ]);

        Position::query()->create([
            'slug'  => 'tester',
            'title' => 'Тестировщик'
        ]);

        Position::query()->create([
            'slug'  => 'designer',
            'title' => 'Дизайнер'
        ]);
    }

    #endregion

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {
        Guard::unguard();

        $this->roles();
        $this->positions();

        Guard::reguard();
    }
}
