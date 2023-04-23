<?php

namespace App\Providers;

use App\Models\Book;
use Inertia\Inertia;
use App\Observers\BookObserver;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;

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
        Inertia::share([
            'errors' => function(){
                return Session::get('errors') 
                ? Session::get('errors')->getBag('default')->getMessages() 
                : (object)[];
            }
        ]);
        
        Inertia::share('flash', function(){
            return [
                'message' => Session::get('message')
            ];
        });
        
        Inertia::share('csrf_token', function(){
            return csrf_token();
        });

        Book::observe(BookObserver::class);
    }
}
