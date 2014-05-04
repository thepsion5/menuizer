<?php

namespace Thepsion5\Menuizer;

use Thepsion5\Menuizer\Exceptions\InvalidNamedRouteException;
use Thepsion5\Menuizer\Exceptions\InvalidUrlRuleException;

class UrlGenerator
{
    protected $canUseNamedRoutes = false;

    protected $routes;

    public function __construct(RouteProviderInterface $routes = null)
    {
        if($routes) {
            $this->setRouteProvider($routes);
        }
    }

    public function generateUrlFromRule($rule, array $params = array())
    {
        $method = 'generateUrlFrom' . ucfirst($rule);
        if(!method_exists($this, $method)) {
            throw new InvalidUrlRuleException("The url rule [$rule] is not valid.");
        }
        return $this->$method($params);
    }

    public function canUseNamedRoutes()
    {
        return $this->routes != null;
    }

    protected function setRouteProvider(RouteProviderInterface $routeProvider)
    {
        $this->routes = $routeProvider;
    }

    protected function generateUrlFromRoute(array $params = array())
    {
        if(!$this->canUseNamedRoutes()) {
            throw new InvalidUrlRuleException("Unable to use the [route] rule without specifying a RouteProviderInterface.");
        }
        $routeName = array_shift($params);
        if(!$this->routes->namedRouteExists($routeName)) {
            throw new InvalidNamedRouteException("Unable to successfully generate a route with the name [$routeName].");
        }
        return $this->routes->getNamedRoute($routeName, $params);
    }

    protected function generateUrlFromUrl(array $params = array())
    {
        return $params[0];
    }
} 