<?php

namespace App\Providers;

use App\Models\Modules\ItemMovement;
use App\Observers\AuditableDataObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        ItemMovement::observe(AuditableDataObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
    }

}
