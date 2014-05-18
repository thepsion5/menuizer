<?php

namespace Thepsion5\Menuizer;


interface RouteProviderInterface
{
    /**
     * @param string $name The name of the route
     * @return bool        True if the route exists, false otherwise
     */
    public function namedRouteExists($name);

    /**
     * @param string $name   The name of the route
     * @param array  $params Any parameters required as part of the route
     * @return string        The provided route's url, or null if the route
     */
    public function getNamedRoute($name, array $params = array());
} 