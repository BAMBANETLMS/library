<?php

namespace BambanetLms\Library;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;
class LibraryServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        Library::boot();

        if (File::exists(__DIR__ . '/Helper/helper.php')) {
            require __DIR__ . '/Helper/helper.php';
        }

        if ($this->app->runningInConsole()) {
            // 数据库迁移
            $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        }

        /**if ($views = $extension->views()) {
            $this->loadViewsFrom($views, 'library');
        }

        if ($this->app->runningInConsole() && $assets = $extension->assets()) {
            $this->publishes(
                [$assets => public_path('vendor/bambanetlms/library')],
                'library'
            );
        }

        $this->app->booted(function () {
            Library::routes(__DIR__.'/../routes/web.php');
        });**/
    }
}