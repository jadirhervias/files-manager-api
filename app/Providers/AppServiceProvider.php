<?php

namespace App\Providers;

use FilesManager\File\Domain\FilesRepository;
use FilesManager\File\Infrastructure\Persistence\Eloquent\EloquentFilesRepository;
use FilesManager\User\Domain\UsersRepository;
use FilesManager\User\Infrastructure\Persistence\Eloquent\EloquentUsersRepository;
use Illuminate\Support\ServiceProvider;

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
    public function boot()
    {
        $this->app->bind(FilesRepository::class, EloquentFilesRepository::class);
        $this->app->bind(UsersRepository::class, EloquentUsersRepository::class);
    }
}
