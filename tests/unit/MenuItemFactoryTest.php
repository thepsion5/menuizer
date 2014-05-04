<?php
use Thepsion5\Menuizer\MenuItemFactory;
use Thepsion5\Menuizer\MenuItem;
use Thepsion5\Menuizer\Support\Testing\MockRouteProvider;
use Thepsion5\Menuizer\UrlGenerator;

/**
 * @group MenuItemFactory
 */
class MenuItemFactoryTest extends TestCase
{
    /**
     * @var MenuItemFactory
     */
    protected $parser;

    /**
     * @var MenuItemFactory
     */
    protected $parserWithRoutes;

    /**
     * @var RouteProviderInterface
     */
    protected $mockRouteProvider;
    
    public function setUp()
    {
        $this->parser = new MenuItemFactory(new UrlGenerator);

        $this->mockRouteProvider = new MockRouteProvider;

        $this->parserWithRoutes = new MenuItemFactory(new UrlGenerator($this->mockRouteProvider));
    }

    /** @test */
    public function it_parses_item_with_hashtag()
    {
        $ruleString = 'label:foo';
        $expectedItem = new MenuItem('#', 'foo');

        $actualItem = $this->parser->makeFromRuleString($ruleString);

        $this->assertEquals($expectedItem, $actualItem);
    }

    /** @test */
    public function it_parses_item_with_url_and_label()
    {
        $ruleString = 'url:/foo|label:Foo';
        $expectedItem = new MenuItem('/foo', 'Foo', array());

        $actualItem = $this->parser->makeFromRuleString($ruleString);

        $this->assertEquals($expectedItem, $actualItem);
    }

    /**
     * @test
     * @expectedException Thepsion5\Menuizer\Exceptions\InvalidMenuItemException
     */
    public function it_throws_error_parsing_blank_url()
    {
        $ruleString = 'url:|label:Foo';

        $this->parser->makeFromRuleString($ruleString);
    }

    /** @test */
    public function it_parses_item_with_route()
    {
        $ruleString = 'route:homepage|label:Foo';
        $expectedItem = new MenuItem('/url_for_homepage', 'Foo');

        $actualItem = $this->parserWithRoutes->makeFromRuleString($ruleString);

        $this->assertEquals($expectedItem, $actualItem);
    }

    /**
     * @test
     * @expectedException Thepsion5\Menuizer\Exceptions\InvalidMenuItemException
     */
    public function it_throws_exception_when_url_rule_invalid()
    {
        $ruleString = 'totally_not_a_real_rule:omg,wat|label:Foo';
        $this->parser->makeFromRuleString($ruleString);
    }

    /**
     * @test
     * @expectedException Thepsion5\Menuizer\Exceptions\InvalidNamedRouteException
     */
    public function it_throws_exception_when_url_rule_not_found_and_no_valid_route()
    {
        $this->mockRouteProvider->routeExists = false;
        $this->parserWithRoutes->makeFromRuleString('also_not_a_real_rule_or_a_route:1|label:Foo');
    }

    /** @test */
    public function it_falls_back_on_named_route_when_rule_not_found()
    {
        $expectedUrl = '/url_for_named_route';
        $item = $this->parserWithRoutes->makeFromRuleString('named_route|label:Foo');

        $this->assertEquals($expectedUrl, $item->getUrl());
    }

    /** @test */
    public function it_parses_item_with_key_value_attributes()
    {
        $ruleString = 'url:/about|label:Foo|attrs:class=bar,id=baz';
        $expectedItem = new MenuItem('/about', 'Foo', array('class' => 'bar', 'id' => 'baz'));

        $actualItem = $this->parser->makeFromRuleString($ruleString);

        $this->assertEquals($expectedItem, $actualItem);
    }

    /** @test */
    public function it_parses_item_with_html_alias_rule()
    {
        $ruleString = 'url:/about|label:Foo|attrs:class=bar|id:baz';
        $expectedItem = new MenuItem('/about', 'Foo', array('class' => 'bar', 'id' => 'baz'));

        $actualItem = $this->parser->makeFromRuleString($ruleString);

        $this->assertEquals($expectedItem, $actualItem);
    }

    /** @test */
    public function it_overwrites_attributes_in_order_of_precedence()
    {
        $ruleStrings = array(
            'url:/foo|label:Foo|attrs:class=bar,id=baz|id:superBaz',
            'url:/foo|label:Foo|id:superBaz|attrs:class=bar,id=baz'
        );
        $expectedItems = array(
            new MenuItem('/foo', 'Foo', array('class' => 'bar', 'id' => 'superBaz')),
            new MenuItem('/foo', 'Foo', array('class' => 'bar', 'id' => 'baz'))
        );

        $actualItems = array(
            $this->parser->makeFromRuleString($ruleStrings[0]),
            $this->parser->makeFromRuleString($ruleStrings[1])
        );

        $this->assertEquals($expectedItems[0], $actualItems[0]);
        $this->assertEquals($expectedItems[1], $actualItems[1]);
    }

    /** @test */
    public function it_properly_creates_attributes_with_no_value()
    {
        $ruleString = 'url:/about|label:Foo|attrs:class=bar,baz';
        $expectedItem = new MenuItem('/about', 'Foo', array('class' => 'bar', 'baz'));

        $actualItem = $this->parser->makeFromRuleString($ruleString);

        $this->assertEquals($expectedItem, $actualItem);
    }

    /** @test */
    public function it_interprets_a_rule_starting_with_a_forward_slash_as_a_url()
    {
        $ruleString = '/about|label:Foo';
        $expectedItem = new MenuItem('/about', 'Foo');

        $actualItem = $this->parser->makeFromRuleString($ruleString);

        $this->assertEquals($expectedItem, $actualItem);
    }

}
