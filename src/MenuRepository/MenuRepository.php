<?php

namespace Thepsion5\Menuizer\MenuRepository;


use Thepsion5\Menuizer\Exceptions\MenuNotFoundException;
use Thepsion5\Menuizer\Menu;

class MenuRepository implements MenuRepositoryInterface
{
    protected $menus = array();

    public function create($name, array $items)
    {
        $menu = new Menu($name, $items);
        $this->menus[$name] = $menu;
        return $menu;
    }

    public function exists($name)
    {
        return isset($this->menus[$name]);
    }

    public function save(Menu $menu)
    {
        $this->menus[$menu->getName()] = $menu;
    }

    public function get($name)
    {
        if(!$this->exists($name)) {
            throw new MenuNotFoundException("Unable to find the menu named [$name].");
        }
        return $this->menus[$name];
    }
}
