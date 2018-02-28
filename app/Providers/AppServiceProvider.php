<?php

namespace App\Providers;

use App\Comment;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('date', function ($expression) {
            return "<?php echo ($expression)->format('F j, Y'); ?>";
        });

        Schema::defaultStringLength(191);
        
        View::share('commentsForSidebar',
            Comment::orderBy('created_at', 'desc')->take(5)->get());
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
