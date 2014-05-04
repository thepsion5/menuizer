<?php
/**
 * Created by PhpStorm.
 * User: Sean
 * Date: 4/18/14
 * Time: 3:11 PM
 */

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
}