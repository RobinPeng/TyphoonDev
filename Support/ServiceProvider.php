<?php
/**
 * User: KylePeng
 * Date: 2016/4/1
 * Time: 15:23
 */

namespace Typhoon\Support;

use Typhoon\Contracts\Foundation\Container as ContainerContract;


abstract class ServiceProvider
{
    public $container;

    abstract public function register();

    public function __construct(ContainerContract $container)
    {
        $this->container = $container;
    }
}