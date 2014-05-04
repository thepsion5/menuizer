<?php
class MenuizerServiceTest extends IntegrationTestCase
{
    public function testCreatesMenu()
    {
        $service = $this->makeService();

        $menu = $service->menu('menu_name', array(
            'url:/|label:Home|class:home',
            'url:/about|label:About Us',
            'url:/contact-us|label:Get in Touch',
            '#|label:Live Chat|id=live-chat'
        ));

        print $menu->render();
    }
} 