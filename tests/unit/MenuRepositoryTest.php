<?php
namespace Thepsion5\Menuizer\Tests\Unit;

use Thepsion5\Menuizer\MenuRepository;

class MenuRepositoryTest extends \Thepsion5\Menuizer\Tests\TestCase
{
    protected $repo;

    public function setUp()
    {
        $this->repo = new MenuRepository;
    }

    /** @test */
    public function it_creates_and_stores_a_new_menu_successfully()
    {
        $menuName = 'test_menu';
        $menuItems = $this->factory->times(3)->menuItem();

        $created = $this->repo->create($menuName, $menuItems);
        $exists = $this->repo->exists($menuName);

        $this->assertInstanceOf('Thepsion5\Menuizer\Menu', $created);
        $this->assertTrue($exists);
    }

    /** @test */
    public function it_retrieves_an_existing_menu_by_name()
    {
        $menuName = 'test_menu';
        $menuItems = $this->factory->times(3)->menuItem();

        $this->repo->create($menuName, $menuItems);
        $menu = $this->repo->get($menuName);

        $this->assertNotNull($menu);
    }

    /**
     * @test
     * @expectedException Thepsion5\Menuizer\Exceptions\MenuNotFoundException
     */
    public function it_throws_an_exception_when_retrieving_a_menu_that_does_not_exist()
    {
        $this->repo->get('not_there');
    }
} 