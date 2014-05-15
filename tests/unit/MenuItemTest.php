<?php
namespace Thepsion5\Menuizer\Tests\Unit;

use Thepsion5\Menuizer\MenuItem;

/**
 * @group MenuItem
 */
class MenuItemTest extends \Thepsion5\Menuizer\Tests\TestCase
{

    /** @test */
    public function it_sets_and_gets_url_and_label()
    {
        $expectedUrl = '/foo';
        $expectedLabel = 'Bar';
        $attributes = array('class' => 'baz');
        $expectedHtmlAttributes = 'class="baz"';

        $item = new MenuItem($expectedUrl, $expectedLabel, $attributes);
        $html = $item->renderWithTemplate(':url :label :attributes');

        $this->assertEquals($expectedUrl, $item->getUrl());
        $this->assertEquals($expectedLabel, $item->getLabel());
        $this->assertContains($expectedHtmlAttributes, $html);
    }

    /**
     * @test
     * @expectedException Thepsion5\Menuizer\Exceptions\InvalidMenuItemException
     */
    public function it_throws_exception_when_attributes_include_href()
    {
        $attributes = array('class' => 'foo', 'href' => '#');

        new MenuItem('/', 'Foo', $attributes);
    }
} 