<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Include file helper tunggal:
        require_once app_path('Helpers/BtechHelper.php');

        // (Opsional) Include semua file helper di folder:
        // foreach (glob(app_path('Helpers/*.php')) as $filename) {
        //     require_once $filename;
        // }
    }
}
