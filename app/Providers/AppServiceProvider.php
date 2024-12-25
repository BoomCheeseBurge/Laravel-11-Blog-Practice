<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Illuminate\Database\Eloquent\Relations\Relation;

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
        Password::defaults(function () {
            $rule = Password::min(8);

            // return $this->app->isProduction()
            //             ? $rule->mixedCase()->uncompromised()
            //             : $rule;

            return $rule->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised();
        });

        Gate::define('admin', fn(User $user) => $user->is_admin);

        Relation::enforceMorphMap([
            'post' => Post::class,
            'comment' => Comment::class,
            'category' => Category::class,
        ]);

        // Use a customized pagination view
        Paginator::defaultView('vendor.pagination.custom');

        /**
         * Throw an exception when attempting to fill an unfillable attribute
         * In other words, help prevent unexpected errors during local development when attempting to set an attribute that has not been added to the model's fillable array
         */
        // Model::preventSilentlyDiscardingAttributes(! $this->app->isProduction());
    }
}
