<?php

namespace Thepsion5\Menuizer\Tests\Unit;

use Thepsion5\Menuizer\ConfigRepository\ConfigRepository;
use Thepsion5\Menuizer\Tests\TestCase;

class ConfigRepositoryTest extends TestCase
{

    protected $testConfigValues = array(
        'category1'  => array(
            'keyA'   => 'valueA',
            'keyB'   => 'valueB',
        ),
        'category2'  => array(
            'keyC'   => 'valueC',
            'keyD'   => 'valueD'
        )
    );

    /**
     * @var ConfigRepository
     */
    protected $config;

    public function setUp()
    {
        $this->config = new ConfigRepository($this->testConfigValues);
    }

    /** @test */
    public function it_retrieves_config_values_used_to_construct_it()
    {
        $expectedValue = $this->testConfigValues['category1']['keyA'];

        $value = $this->config->get('category1', 'keyA');

        $this->assertEquals($expectedValue, $value);
    }

    /** @test */
    public function it_successfully_sets_values_for_an_existing_category_and_key()
    {
        $setValue = 'valueZ';

        $this->config->set('category1', 'keyA', $setValue);

        $retrievedValue = $this->config->get('category1', 'keyA');

        $this->assertEquals($setValue, $retrievedValue);
    }

    /**
     * @test
     * @expectedException \Thepsion5\Menuizer\Exceptions\InvalidConfigException
     */
    public function it_throws_an_exception_for_a_nonexistent_key()
    {
        $this->config->get('category1', 'foo');
    }

    /**
     * @test
     * @expectedException \Thepsion5\Menuizer\Exceptions\InvalidConfigException
     */
    public function it_throws_an_exception_for_a_nonexistent_category()
    {
        $this->config->get('categoryZ', 'foo');
    }

    /** @test */
    public function it_sets_all_config_values()
    {
        $values = array(
            'category1'  => array(
                'keyA'   => 'valueH',
                'keyB'   => 'valueI',
            ),
            'category2'  => array(
                'keyC'   => 'valueJ',
                'keyD'   => 'valueK'
            )
        );

        $this->config->setAll($values);

        $this->assertEquals($values['category1']['keyA'], $this->config->get('category1', 'keyA'));
        $this->assertEquals($values['category2']['keyD'], $this->config->get('category2', 'keyD'));
    }

    /** @test */
    public function it_retrieves_all_config_values()
    {
        $configValues = $this->config->all();

        $this->assertEquals($this->testConfigValues, $configValues);
    }
}
