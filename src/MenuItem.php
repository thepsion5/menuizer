<?php
namespace Thepsion5\Menuizer;

use Thepsion5\Menuizer\Exceptions\InvalidMenuItemException;

class MenuItem
{
    protected $url;

    protected $label = '';

    protected $attributes = array();

    public function __construct($url, $label = '', array $attributes = array())
    {
        $this->setUrl($url);
        if($label) {
            $this->setLabel($label);
        }
        if($attributes) {
            $this->setAttributes($attributes);
        }
    }

    protected function setUrl($url)
    {
        if($url == '') {
            throw new InvalidMenuItemException('The Menu Item URL cannot be blank.');
        }
        $this->url = (string) $url;
    }

    public function getUrl()
    {
        return $this->url;
    }

    protected function setLabel($label)
    {
        $this->label = (string) $label;
    }

    public function getLabel()
    {
        return $this->label;
    }

    protected function setAttributes(array $attributes)
    {
        if(isset($attributes['href'])) {
            throw new InvalidMenuItemException('The "href" attribute must be set via a URL rule, not using an attribute rule.');
        }
        $this->attributes = $attributes;
    }

    public function renderWithTemplate($template)
    {
        $search = array(':url', ':label', ':attributes');
        $attributeString = array_to_html_attrs($this->attributes);
        $replace = array($this->url, $this->label, $attributeString);
        return str_replace($search, $replace, $template);
    }

}
