<?php
namespace Thepsion5\Menuizer\Tests\Unit;

use Thepsion5\Menuizer\Menu;

class MenuTest extends \Thepsion5\Menuizer\Tests\TestCase
{
    public function setUp()
    {
        $this->menu = new Menu('test_menu');
    }

    /** @test */
    public function it_sets_its_name()
    {
        $expectedNames = array('test_name', 'some_other_name');
        $actualNames = array();
        $menu1 = new Menu($expectedNames[0]);
        $actualNames[] = $menu1->getName();

        $menu2 = new Menu($expectedNames[0]);
        $menu2->setName($expectedNames[1]);
        $actualNames[] = $menu2->getName();

        $this->assertEquals($expectedNames[0], $actualNames[0]);
        $this->assertEquals($expectedNames[1], $actualNames[1]);
    }

    /**
     * @test
     * @expectedException Thepsion5\Menuizer\Exceptions\InvalidMenuNameException
     */
    public function it_throws_exception_on_empty_name()
    {
        $menu = new Menu('');
    }

    /** @test */
    public function it_sets_its_item_template()
    {
        $expectedTemplate = ':url :label :attributes';

        $this->menu->setItemTemplate($expectedTemplate);
        $template = $this->menu->getItemTemplate();

        $menu = new Menu('name', array(), $expectedTemplate);
        $template2 = $menu->getItemTemplate();

        $this->assertEquals($expectedTemplate, $template);
        $this->assertEquals($expectedTemplate, $template2);
    }

    /**
     * @test
     * @expectedException Thepsion5\Menuizer\Exceptions\InvalidTemplateException
     */
    public function it_throws_exception_on_empty_item_template()
    {
        $this->menu->setItemTemplate('');
    }

    /** @test */
    public function it_sets_a_single_item()
    {
        $expectedItem = $this->factory->menuItem();

        $this->menu->setItem(0, $expectedItem);
        $retrievedItem = $this->menu->getItem(0);

        $this->assertEquals($expectedItem, $retrievedItem);
    }

    /** @test */
    public function it_sets_multiple_items()
    {
        $expectedItems = $this->factory->times(3)->menuItem();

        $this->menu->setItems($expectedItems);

        $this->assertEquals($expectedItems[0], $this->menu->getItem(0));
        $this->assertEquals($expectedItems[1], $this->menu->getItem(1));
        $this->assertEquals($expectedItems[2], $this->menu->getItem(2));
    }

    /** @test */
    public function it_retrieves_items_via_array_access()
    {
        $menuItems = $this->factory->times(3)->menuItem();
        $menu = new Menu('menu', $menuItems);

        $this->assertEquals($menuItems[0], $menu[0]);
        $this->assertEquals($menuItems[1], $menu[1]);
        $this->assertEquals($menuItems[2], $menu[2]);
    }

    /** @test */
    public function it_removes_items_via_array_access()
    {
        $menuItems = $this->factory->times(3)->menuItem();
        $menu = new Menu('menu', $menuItems);

        unset($menu[1]);
        $this->assertNull($menu[1]);
        $this->assertFalse(isset($menu[1]));
    }

    /** @test */
    public function it_sets_items_via_array_access()
    {
        $additionalItem = $this->factory->menuItem();
        $this->menu[4] = $additionalItem;

        $this->assertTrue(isset($this->menu[4]));
        $this->assertEquals($additionalItem, $this->menu[4]);
    }

    /** @test */
    public function it_renders_test_items_with_its_template()
    {
        $attributes = array('url' => 'TEST_URL', 'label' => 'TEST_LABEL', 'attributes' => array('class' => 'TEST_CLASS'));
        $items = $this->factory->times(2)->menuItem($attributes);
        $menu = new Menu('test', $items, ':url :label :attributes<br />');

        $html = $menu->render();
        $expectedHtml = "TEST_URL TEST_LABEL class=\"TEST_CLASS\"<br />\nTEST_URL TEST_LABEL class=\"TEST_CLASS\"<br />";

        $this->assertContains($expectedHtml, $html);
    }

}
