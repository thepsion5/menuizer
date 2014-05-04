<?php

use Thepsion5\Menuizer\Support\Testing\MenuizerTestFactory;

class TestCase extends PHPUnit_Framework_TestCase
{
    protected $factory;

    public function __construct($name = null, array $data = array(), $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->factory = new MenuizerTestFactory;
    }

    public function tearDown()
    {
        Mockery::close();
    }


} 