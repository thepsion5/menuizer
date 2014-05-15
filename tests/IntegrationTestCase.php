<?php
namespace Thepsion5\Menuizer\Tests;

use Thepsion5\Menuizer\MenuizerService;
use Thepsion5\Menuizer\RouteProviderInterface;
use Thepsion5\Menuizer\Tests\Support\MockRouteProvider;

class IntegrationTestCase extends TestCase
{
    protected function makeService(RouteProviderInterface $provider = null)
    {
        return MenuizerService::create($provider);
    }

    protected function makeServiceWithMockRouteProvider($format = '', $exists = true)
    {
        return $this->makeService(new MockRouteProvider($format, $exists));
    }

}