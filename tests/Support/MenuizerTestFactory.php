<?php

namespace Thepsion5\Menuizer\Tests\Support;

use Thepsion5\Menuizer\Menu;
use Thepsion5\Menuizer\MenuItem;

class MenuizerTestFactory
{
    protected $itemsToProduce = 1;

    protected $blueprints = array(
        'MenuItem' => array(
            'url'           => '/',
            'label'         => 'Label',
            'attributes'    => array('class' => 'menu-item')
        ),
        'Menu' => array(
            'name'          => 'test_menu',
            'menuTemplate'  => ':menu',
            'itemTemplate'  => '<a href=":url" :attributes>:label</a>'
        )
    );


    public function times($number)
    {
        $this->itemsToProduce = (int) $number;

        return $this;
    }

    public function menuItem(array $attributes = array())
    {
        $attributes = $this->mergeBlueprintAttributes('MenuItem', $attributes);

        $items = array();
        for($index = 0; $index < $this->itemsToProduce; $index++) {
            $items[] = new MenuItem($attributes['url'], $attributes['label'], $attributes['attributes']);
        }
        $this->times(1);
        if(count($items) == 1) {
            $items = $items[0];
        }
        return $items;
    }

    public function menu(array $attributes = array(), $items = array())
    {
        $attributes = $this->mergeBlueprintAttributes('Menu', $attributes);
        $menus = array();
        if(count($items) < 1) {
            $items = array(
                $this->menuItem(array('url' => '/1', 'label' => 'Item 1')),
                $this->menuItem(array('url' => '/2', 'label' => 'Item 2')),
                $this->menuItem(array('url' => '/3', 'label' => 'Item 3'))
            );
        }
        for($index = 0; $index < $this->itemsToProduce; $index++) {
            $menus[] = new Menu($attributes['name'], $items, $attributes['itemTemplate'], $attributes['menuTemplate']);
        }
        $this->times(1);
        if(count($menus) == 1) {
            $menus = $menus[0];
        }
        return $menus;
    }

    protected function mergeBlueprintAttributes($blueprint, array $attributes)
    {
        $defaults = $this->blueprints[$blueprint];
        return array_merge($defaults, $attributes);
    }
}
