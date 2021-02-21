<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {
  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot() {
    $this->app['request']->server->set('HTTPS', true);
  }

  /**
   * Register any application services.
   *
   * @return void
   */
  public function register() {
    $request = app('request');

    if ($request->getMethod() === 'OPTIONS') {
      app()->options($request->path(), function () {
        return response('OK', 200)
          ->header('Access-Control-Allow-Origin', '*')
          ->header('Access-Control-Allow-Methods', 'OPTIONS, GET, POST, PUT, DELETE')
          ->header('Access-Control-Allow-Headers', 'Content-Type, Origin');
      });
    }
  }
}
