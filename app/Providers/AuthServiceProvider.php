<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Blade;
use App\Traits\HasRolesAndPermissions;
use App\Models\SuperAdmin;
use App\Models\Category;
use App\Policies\CategoryPolicy;


class AuthServiceProvider extends ServiceProvider
{use HasRolesAndPermissions;
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Category' => 'App\Policies\CategoryPolicy',
       // Category::class => CategoryPolicy::class,
       \App\Models\Category::class => \App\Policies\CategoryPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //  Gate::define('isAdmin', function (SuperAdmin $superadmin) {
        //     return $superadmin->roles()->first()->slug === 'admin' ;
        //  });
        // Gate::before(function (SuperAdmin $user, $ability) {
        //     if ($user->isAdmin()) {
        //     return $user->roles->first()->slug == 'admin' ? true : null;
        //     }
        // });

        //dd($user);
        // Gate::before(function (SuperAdmin $user){
        //     if($user->roles->pluck('role_id')->contains('admin')){
        //         return true;
        //     }
       // });
       Gate::define('isPage', function ($user) {
        return $user->pages->first();
    });
    Gate::define('isAd', function ($user) {
        return $user->proles->first()->slug == 'admin';
    });
    
    Gate::define('isMa', function ($user) {
        return $user->proles->first()->slug == 'manager';
    });

    Gate::define('isCEd', function ($user) {
        return $user->proles->first()->slug == 'content-editor';
    });
         
 Gate::define('isAdmin', function(SuperAdmin $superadmin) {
      
        return $superadmin->roles->first()->slug=='admin';
        
     });
Gate::define('isManager', function(SuperAdmin $superadmin) {
        return $superadmin->roles->first()->slug=='manager';
    });
        // Gate::define('isManager', function (SuperAdmin $user) {
        //     return $user->roles()->first();
        // });
        Gate::define('isContentEditor', function (SuperAdmin $superadmin) {
            return $superadmin->roles->first()->slug=="content-editor";
        });

      
    }
   
}
