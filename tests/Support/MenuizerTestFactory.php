<?php

namespace Thepsion5\Menuizer\Tests\Support;

use Thepsion5\Menuizer\MenuItem;

class MenuizerTestFactory
{
    protected $itemsToProduce = 1;

    protected $blueprints = array(
        'MenuItem' => array(
            'url' => '/',
            'label' => 'Label',
            'attributes' => array('class' => 'menu-item')
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

    protected function mergeBlueprintAttributes($blueprint, array $attributes)
    {
        $defaults = $this->blueprints[$blueprint];
        return array_merge($defaults, $attributes);
    }
} 