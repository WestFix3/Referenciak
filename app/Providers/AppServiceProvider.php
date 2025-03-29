<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Position;
use App\Policies\UserPolicy;
use App\Policies\PositionPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

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
        // Policy regisztrálása a create jogosultságra
        Gate::define('create', [UserPolicy::class, 'create']);

        // Új jogosultság regisztrálása a munkakör szerkesztéséhez
        // Gate::define('update-position', function (User $user, Position $position) {
        //     return $user->is_admin;  
        // });
        //$this->registerPolicies();
        Gate::define('create', function ($user) {
            return $user->is_admin;
        });
        Gate::define('update', function ($user, Position $position) {
            return $user->is_admin;
        });
        Gate::define('delete', function ($user, Position $position) {
            return $user->is_admin;
        });
    }
}
