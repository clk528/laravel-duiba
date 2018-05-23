<?php
/**
 * Created by PhpStorm.
 * User: clk
 * Date: 2018/5/23
 * Time: 10:15
 */

namespace clk528\DuiBa\Providers;

use Illuminate\Support\ServiceProvider;

use clk528\DuiBa\DuiBa;

class DuiBaProvider extends ServiceProvider
{
    /**
     * Determin is defer.
     *
     * @var bool
     */
    protected $defer = true;

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                dirname(__DIR__) . '/config.php' => config_path('duiba.php'),],
                'laravel-duiba'
            );
        }
    }

    /**
     * Regist the services
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('DuiBa', DuiBa::class);
    }
}