<?php
namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use NumberFormatter; // <-- Add this line

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();

        // ✅ Add helper function for amount in words
        if (!function_exists('amountToWords')) {
            function amountToWords($number)
            {
                $f = new NumberFormatter('en', NumberFormatter::SPELLOUT);
                return 'Rupees ' . ucwords($f->format($number)) . ' Only';
            }
        }
    }
}
