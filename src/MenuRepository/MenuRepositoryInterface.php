<?php
namespace Thepsion5\Menuizer\MenuRepository;

use Thepsion5\Menuizer\Menu;

interface MenuRepositoryInterface
{
    /**
     * @param string $menuName The name of the menu
     * @param array  $items    The items that make up the menu
     * @return \Thepsion5\Menuizer\Menu The newly-created menu
     */
    public function create($menuName, array $items);

    /**
     * @param \Thepsion5\Menuizer\Menu $menu The menu to save
     */
    public function save(Menu $menu);

    /**
     * @param string $menuName The name of the menu
     * @return bool True if the menu exists, false otherwise
     */
    public function exists($menuName);

    /**
     * @param string $menuName The name of the menu to retrieve
     * @return \Thepsion5\Menuizer\Menu The retrieved menu
     * @throws \Thepsion5\Menuizer\Exceptions\MenuNotFoundException
     */
    public function get($menuName);
}
