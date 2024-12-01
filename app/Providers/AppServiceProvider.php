<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Support\Facades\Gate;
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
        ]);
    }
}
