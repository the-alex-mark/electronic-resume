<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('checked', function ($expression) {
            return "<?php echo ($expression) ? 'checked=\"\"' : ''; ?>";
        });

        Blade::directive('selected', function ($expression) {
            return "<?php echo ($expression) ? 'selected=\"\"' : ''; ?>";
        });

        Blade::directive('disabled', function ($expression) {
            return "<?php echo ($expression) ? 'disabled=\"\"' : ''; ?>";
        });

        Blade::directive('readonly', function ($expression) {
            return "<?php echo ($expression) ? 'readonly=\"\"' : ''; ?>";
        });

        Blade::directive('required', function ($expression) {
            return "<?php echo ($expression) ? 'required=\"\"' : ''; ?>";
        });
    }
}
