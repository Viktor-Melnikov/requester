<?php
/**
 * Created by Viktor Melnikov.
 * Date: 2020-04-01
 * GitHub: viktor-melnikov
 */
declare(strict_types=1);

namespace Requester;

use Illuminate\Support\ServiceProvider;
use Requester\Contracts\ParserInterface;
use Requester\Parsers\JsonParser;

class RequestServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('JsonParser', function () {
            return new JsonParser;
        });
        $this->app->bind(ParserInterface::class, 'JsonParser');
    }
}