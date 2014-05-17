<?php

namespace Thepsion5\Menuizer\Support\Laravel;


use Illuminate\Routing\UrlGenerator;
use Thepsion5\Menuizer\RouteProviderInterface;

class LaravelRouteProvider implements RouteProviderInterface
{
    public function __construct(UrlGenerator $urls)
    {
        $this->urls = $urls;
    }

    public function getNamedRoute($name, array $params = array())
    {
        return $this->urls->route($name, $params);
    }

    public function namedRouteExists($name)
    {
        $exists = true;
        try {
            $this->urls->route($name);
        } catch(\InvalidArgumentException $e) {
            $exists = false;
        }
        return $exists;
    }
}
