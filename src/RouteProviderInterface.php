<?php

namespace Thepsion5\Menuizer;


interface RouteProviderInterface
{
    public function namedRouteExists($name);

    public function getNamedRoute($name, array $params = array());
} 