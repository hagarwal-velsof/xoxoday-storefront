<?php

namespace Xoxoday\Storefront;

use Illuminate\Support\ServiceProvider;

class StorefrontServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
   
    public function boot()
    {
        
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');
        $this->loadViewsFrom(__DIR__.'/resources/views','storefront');

        if ($this->app->runningInConsole()) {
            // Publish assets
            $this->publishes([
              __DIR__.'/config/xostorefront.php' => config_path('xostorefront.php'),
              __DIR__.'/resources/assets' => public_path('storefront'),
              __DIR__.'/Database/Seeders/StateSeeder.php' => database_path('Seeders/StateSeeder.php'),
              __DIR__.'/Database/Seeders/ProductSeeder.php' => database_path('Seeders/ProductSeeder.php'),
            ], 'xostorefront_assets');
          
          }
    }

   
}
