<?php

namespace Thepsion5\Menuizer\ConfigRepository;


interface ConfigRepositoryInterface
{
    public function get($category, $key);

    public function set($category, $key, $value);

    public function all();

    public function setAll(array $config);
}
