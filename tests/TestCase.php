<?php
namespace Thepsion5\Menuizer\Tests;

class TestCase extends \PHPUnit_Framework_TestCase
{
    protected $factory;

    public function __construct($name = null, array $data = array(), $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->factory = new Support\MenuizerTestFactory;
    }
}
