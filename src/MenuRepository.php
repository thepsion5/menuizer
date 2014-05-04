<?php

namespace Thepsion5\Menuizer;


use Thepsion5\Menuizer\Exceptions\MenuNotFoundException;

class MenuRepository
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

    public function get($name)
    {
        if(!$this->exists($name)) {
            throw new MenuNotFoundException("Unable to find the menu named [$name].");
        }
        return $this->menus[$name];
    }
}
