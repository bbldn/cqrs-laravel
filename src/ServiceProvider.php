<?php

namespace BBLDN\CQRSLaravel;

use BBLDN\CQRS\QueryBus\QueryBus;
use BBLDN\CQRS\CommandBus\CommandBus;
use BBLDN\CQRSLaravel\QueryBus\QueryBusImpl;
use BBLDN\CQRSLaravel\QueryBus\QueryRegistry;
use Illuminate\Support\ServiceProvider as Base;
use BBLDN\CQRSLaravel\CommandBus\CommandBusImpl;
use BBLDN\CQRSLaravel\CommandBus\CommandRegistry;
use Illuminate\Contracts\Container\Container as Application;

class ServiceProvider extends Base
{
    /**
     * @return void
     */
    public function boot(): void
    {
        $this->publishes([__DIR__ . '/config/cqrs.php' => $this->app->configPath('cqrs.php')]);
    }

    /**
     * @return list<class-string>
     */
    public function provides(): array
    {
        return [
            QueryBus::class,
            CommandBus::class,
            QueryRegistry::class,
            CommandRegistry::class,
        ];
    }

    /**
     * @return void
     */
    public function register(): void
    {
        /* Query | Start */
        $this->app->singleton(QueryBus::class, static function (Application $app): QueryBusImpl {
            return new QueryBusImpl($app, $app->get(QueryRegistry::class));
        });

        $this->app->singleton(QueryRegistry::class, static function (Application $app): QueryRegistry {
            return new QueryRegistry($app->make('config')->get('cqrs.queryMap', []));
        });
        /* Query | End */

        /* Command | Start */
        $this->app->singleton(CommandBus::class, static function (Application $app): CommandBusImpl {
            return new CommandBusImpl($app, $app->get(CommandRegistry::class));
        });

        $this->app->singleton(CommandRegistry::class, static function (Application $app): CommandRegistry {
            return new CommandRegistry($app->make('config')->get('cqrs.commandMap', []));
        });
        /* Command | End */
    }
}
