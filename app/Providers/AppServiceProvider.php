<?php

namespace App\Providers;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::before(function (User $user, string $ability) {
            if ($user->hasRole('system-administrator')) {
                return true;
            }

            return null;
        });

        try {
            if (! Schema::hasTable('permissions')) {
                return;
            }

            Permission::query()
                ->pluck('slug')
                ->each(function (string $slug) {
                    Gate::define(
                        $slug,
                        fn (User $user) => $user->hasPermission($slug)
                    );
                });
        } catch (\Throwable $exception) {
            report($exception);
        }
    }
}