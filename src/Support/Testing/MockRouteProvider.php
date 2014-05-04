<?php
namespace Thepsion5\Menuizer\Support\Testing;

use Thepsion5\Menuizer\RouteProviderInterface;

class MockRouteProvider implements RouteProviderInterface
{

    public $format ='/url_for_%s%s';

    public $routeExists = true;

    public function namedRouteExists($name)
    {
        return $this->routeExists;
    }

    public function getNamedRoute($name, array $params = array())
    {
        $queryString = '?';
        foreach($params as $name => $value) {
            $queryString .= "$name=$value&";
        }
        $queryString = trim($queryString, '&?');
        return sprintf($this->format, $name, $queryString);
    }
}
