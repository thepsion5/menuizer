<?php

namespace Thepsion5\Menuizer;

use Thepsion5\Menuizer\Exceptions\InvalidMenuNameException,
    Thepsion5\Menuizer\Exceptions\InvalidTemplateException;

class Menu implements \ArrayAccess
{
    protected $name;

    protected $items = array();

    protected $menuTemplate = ':menu';

    protected $itemTemplate = '<li><a href=":url" :attributes>:label</a></li>';

    public function __construct($name, array $items = array(), $template = '', $menuTemplate = '')
    {
        $this->setName($name);
        $this->setItems($items);
        if($template) {
            $this->setItemTemplate($template);
        }
        if($menuTemplate) {
            $this->setMenuTemplate($menuTemplate);
        }
    }

    public function setName($name)
    {
        if($name == '') {
            throw new InvalidMenuNameException('Menu names cannot be empty.');
        } elseif(!is_string($name)) {
            throw new InvalidMenuNameException('Menu names must be strings.');
        }
        $this->name = $name;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setItems(array $items)
    {
        for($index = 0; $index < count($items); $index++) {
            $this->setItem($index, $items[$index]);
        }

        return $this;
    }

    public function setItem($index, MenuItem $item)
    {
        $this->items[$index] = $item;

        return $this;
    }

    public function getItem($index)
    {
        return (isset($this->items[$index])) ? $this->items[$index] : null;
    }

    public function setMenuTemplate($template)
    {
        if($template == '') {
            throw new InvalidTemplateException('Templates Cannot be empty.');
        }
        $this->menuTemplate = $template;
    }

    public function getMenuTemplate()
    {
        return $this->menuTemplate;
    }

    public function setItemTemplate($template)
    {
        if($template == '') {
            throw new InvalidTemplateException('Templates Cannot be empty.');
        }
        $this->itemTemplate = $template;
    }

    public function getItemTemplate()
    {
        return $this->itemTemplate;
    }

    public function render($menuTemplate = '')
    {
        $menuTemplate = $menuTemplate ?: $this->menuTemplate;
        $html = array();
        foreach($this->items as $item) {
            $html[] = $item->renderWithTemplate($this->itemTemplate);
        }
        $html = implode("\n", $html);
        return str_replace(':menu', $html, $menuTemplate);
    }

    public function offsetExists($offset)
    {
        return isset($this->items[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->getItem($offset);
    }

    public function offsetSet($offset, $value)
    {
        $this->setItem($offset, $value);
    }

    public function offsetUnset($offset)
    {
        unset($this->items[$offset]);
    }
}
