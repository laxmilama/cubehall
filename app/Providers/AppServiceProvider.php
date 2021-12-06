<?php

namespace App\Providers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Schema;

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
    // public function boot()
    // {
    //    // Schema::defaultStringLength(191);
    // //    if($this->app->environment('production')) {
    // //     \URL::forceScheme('https');
    // // }
    // }

    public function boot()
    {
        Schema::defaultStringLength(191);
        
        if(!Cookie::get('symbol')){
            Cookie::queue(Cookie::forever('symbol', 'Rs.'));            
        }

        if(!Cookie::get('currency')){
            Cookie::queue(Cookie::forever('currency', 'NPR'));            
        }
        
        // force to https
        
        // if ($this->app->environment('production')) {
        //     \URL::forceScheme('https');
        // }

        JsonResource::withoutWrapping();
        /**
         * Paginate a standard Laravel Collection.
         *
         * @param int $perPage
         * @param int $total
         * @param int $page
         * @param string $pageName
         * @return array
         */
        Collection::macro('paginate', function ($perPage, $total = null, $page = null, $pageName = 'page') {
            $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);

            return new LengthAwarePaginator(
                $this->forPage($page, $perPage),
                $total ?: $this->count(),
                $perPage,
                $page,
                [
                    'path' => LengthAwarePaginator::resolveCurrentPath(),
                    'pageName' => $pageName,
                ]
            );
        });
    }
}
