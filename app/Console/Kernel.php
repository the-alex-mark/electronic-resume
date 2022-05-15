<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\File;

class Kernel extends ConsoleKernel {

    /**
     * @inheritDoc
     */
    protected function schedule(Schedule $schedule) {

        // Очистка временных файлов
        $schedule
            ->call(function () {
                File::delete(File::glob(public_path('storage/tests/*')));
            })
            ->daily();
    }

    /**
     * @inheritDoc
     */
    protected function commands() {
        $this->load(__DIR__ . '/Commands');
    }
}
