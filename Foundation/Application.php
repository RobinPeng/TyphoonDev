<?php

namespace Typhoon\Foundation;

use Typhoon\Contracts\Foundation\Application as ApplicationContract;
use Typhoon\Contracts\Foundation\Container As ContainerContract;

class Application implements ApplicationContract
{
    use RouteTrait;

    protected $container;

    protected $serviceProviders = [];
    protected $loadedProviders = [];

    protected $aliases = [];

    public function __construct($container = [])
    {
        if (is_array($container)) {
            $container = new Container($container);
        }

        if (!$container instanceof ContainerContract) {
            throw new \InvalidArgumentException('Expected a ContainerContract');
        }

        $this->container = $container;

        $this->registerCoreContainerAliases();
        $this->registerDefaultProviders();
    }

    public function run()
    {
        // TODO: Implement run() method.
    }

    public function registerDefaultProviders()
    {

    }

    public function registerCoreContainerAliases()
    {
        $aliases = [
            'request' => \Typhoon\Http\Reqeust::class,
        ];

        foreach ($aliases as $key => $alias) {
            $this->container[$key] = function () use ($alias) {
                return new $alias;
            };
        }
    }

    /**
     * Calling a non-existant method on App checks to see if there's an item
     * in the container than is callable and if so, calls it.
     *
     * @param  string $method
     * @param  array $args
     * @return mixed
     */
    public function __call($method, $args)
    {
        if ($this->container->has($method)) {
            $obj = $this->container->get($method);
            if (is_callable($obj)) {
                return call_user_func_array($obj, $args);
            }
        }

        throw new \BadMethodCallException("Method $method is not a valid method");
    }
}