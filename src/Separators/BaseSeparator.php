<?php


namespace DynamicAcl\Separators;


use Illuminate\Support\Collection;
use DynamicAcl\Route;

abstract class BaseSeparator
{
    protected $routes;

    public function __construct(Route $route)
    {
        $this->routes = $route->getUserDefined();
    }

    abstract public function getRoutes();

    abstract public function checkAccess($access, $permissions): bool;
}