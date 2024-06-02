<?php

namespace App\Providers;

use App\Models\Department;
use App\Models\Material;
use App\Models\Position;
use App\Models\User;
use App\Models\Worker;
use App\Policies\DepartmentPolicy;
use App\Policies\MaterialPolicy;
use App\Policies\PositionPolicy;
use App\Policies\WorkerPolicy;
use Illuminate\Support\Facades\Gate;
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
        Gate::policy(Department::class, DepartmentPolicy::class);
        Gate::policy(Position::class, PositionPolicy::class);
        Gate::policy(Worker::class, WorkerPolicy::class);

        Gate::define('downloadLogs', function (User $user) {
            return $user->role_id == 1;
        });

        Gate::policy(Material::class, MaterialPolicy::class);
    }
}
