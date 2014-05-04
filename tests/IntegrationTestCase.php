<?php


use Thepsion5\Menuizer\MenuizerService;
use Thepsion5\Menuizer\RouteProviderInterface;
use Thepsion5\Menuizer\Support\Testing\MenuizerTestFactory;

class IntegrationTestCase extends TestCase
{

    protected function makeService(RouteProviderInterface $provider = null)
    {
        return MenuizerService::create($provider);
    }

}