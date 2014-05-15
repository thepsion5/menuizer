<?php
namespace Thepsion5\Menuizer\Tests\Support;

use Thepsion5\Menuizer\RouteProviderInterface;

class MockRouteProvider implements RouteProviderInterface
{

    public $format = '';

    public $routeExists = true;

    public function __construct($urlFormat = '/url_for_%s%s', $routeExists = true)
    {
        $this->format = $urlFormat;
        $this->routeExists = $routeExists;
    }

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
