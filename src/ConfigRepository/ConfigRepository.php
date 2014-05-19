<?php

namespace Thepsion5\Menuizer\ConfigRepository;

use Thepsion5\Menuizer\Exceptions\InvalidConfigException;

class ConfigRepository implements ConfigRepositoryInterface
{
    protected $config = array(
        'menus' => array(
            'default-template' => ':menu'
        ),
        'items' => array(
            'default-template' => '<li><a href=":url" :attributes>:label</a></li>'
        )
    );

    public function __construct(array $config = array())
    {
        if(count($config) > 0) {
            $this->config = $config;
        }
    }

    protected function checkConfig($category, $key)
    {
        if(!isset($this->config[$category])) {
            throw new InvalidConfigException("The configuration category [$category] does not exist.");
        } elseif(!isset($this->config[$category][$key])) {
            throw new InvalidConfigException("The configuration key [$key] does not exist for this category.");
        }
    }

    public function get($category, $key)
    {
        $this->checkConfig($category, $key);
        return $this->config[$category][$key];
    }

    public function all()
    {
        return $this->config;
    }

    public function set($category, $key, $value)
    {
        $this->checkConfig($category, $key);
        $this->config[$category][$key] = $value;
    }

    public function setAll(array $config)
    {
        foreach($config as $category => $keys) {
            foreach($keys as $key => $value) {
                $this->set($category, $key, $value);
            }
        }
    }
}
