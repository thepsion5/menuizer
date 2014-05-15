<?php
namespace Thepsion5\Menuizer\TestsIntegration;

class MenuizerServiceTest extends \Thepsion5\Menuizer\Tests\IntegrationTestCase
{
    /**
     * @var \Thepsion5\Menuizer\MenuizerService
     */
    protected $menuizer;

    /**
     * @var \Thepsion5\Menuizer\MenuizerService
     */
    protected $routeMenuizer;

    protected function setUp()
    {
        $this->menuizer = $this->makeService();
        $this->routeMenuizer = $this->makeServiceWithMockRouteProvider('/route_%s%s');
    }

    /** @test */
    public function it_generates_a_menu_with_no_label_or_attributes()
    {
        $menu = $this->menuizer->menu('menu_name', array('/'));

        $renderedMenu = $menu->render();

        $this->assertContains('<a href="/" ></a>', $renderedMenu);
    }

    /** @test */
    public function it_generates_a_menu_with_a_hash_url()
    {
        $menu = $this->menuizer->menu('menu_name', array('#foo'));

        $renderedMenu = $menu->render();

        $this->assertContains('href="#foo"', $renderedMenu);
    }

    /** @test */
    public function it_generates_a_menu_with_a_route_url()
    {
        $menu = $this->routeMenuizer->menu('menu_name', array('route:foo'));

        $renderedMenu = $menu->render();

        $this->assertContains('href="/route_foo"', $renderedMenu);
    }

    /** @test */
    public function it_generates_a_menu_with_a_label_and_attributes()
    {
        $menu = $this->menuizer->menu('menu_name', array('/|label:Foo|class:bar|id:baz'));

        $renderedMenu = $menu->render();

        $this->assertContains('href="/"', $renderedMenu);
        $this->assertContains("Foo", $renderedMenu);
        $this->assertContains('class="bar"', $renderedMenu);
        $this->assertContains('id="baz"', $renderedMenu);
    }

    /** @test */
    public function it_generates_a_menu_with_a_hash_item()
    {
        $menu = $this->menuizer->menu('menu_name', array('#foo'));

        $renderedMenu = $menu->render();

        $this->assertContains('href="#foo"', $renderedMenu);
    }

    /** @test */
    public function it_retrieves_a_previously_defined_menu()
    {
        $name = 'test_menu';
        $this->menuizer->define($name, array('#foo'));

        $menu = $this->menuizer->menu($name);

        $this->assertEquals($name, $menu->getName());
    }

    /**
     * @test
     * @expectedException \Thepsion5\Menuizer\Exceptions\MenuNotFoundException
     */
    public function it_throws_an_exception_retrieving_a_nonexistent_menu()
    {
        $this->menuizer->menu('does_not_exist');
    }

    /** @test */
    public function it_renders_a_newly_defined_menu()
    {
        $renderedMenu = $this->menuizer->render('menu_name', array('#foo'));

        $this->assertContains('href="#foo"', $renderedMenu);
    }

    /** @test */
    public function it_renders_a_previously_defined_menu()
    {
        $this->menuizer->define('menu_name', array('#foo'));

        $renderedMenu = $this->menuizer->render('menu_name');

        $this->assertContains('href="#foo"', $renderedMenu);
    }
} 