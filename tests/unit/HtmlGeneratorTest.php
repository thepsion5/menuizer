<?php
namespace Thepsion5\Menuizer\Tests\Unit;

use Thepsion5\Menuizer\HtmlGenerator;

class HtmlGeneratorTest extends \Thepsion5\Menuizer\Tests\TestCase
{

    /**
     * @var HtmlGenerator
     */
    protected $generator;

    public function setUp()
    {
        $this->generator = new HtmlGenerator;
    }

    protected function getFilledDefaultTemplate($url = '', $label = '', $attributeString = '')
    {
        return "<li><a href=\"$url\" $attributeString>$label</a></li>";
    }

    /** @test */
    public function it_sets_a_custom_template()
    {
        $expectedTemplate = 'asdf';
        $this->generator->setTemplate($expectedTemplate);
        $template = $this->generator->getTemplate();

        $this->assertEquals($expectedTemplate, $template);
    }



    /** @test */
    public function it_generates_html_with_a_url_and_no_label()
    {
        $url = '/';
        $expectedHtml = $this->getFilledDefaultTemplate($url);

        $html = $this->generator->generateItemHtml($url);

        $this->assertEquals($expectedHtml, $html);
    }

    /** @test */
    public function it_generates_html_with_a_url_and_label()
    {
        $url = '/';
        $label = 'Label';
        $expectedHtml = $this->getFilledDefaultTemplate($url, $label);

        $html = $this->generator->generateItemHtml($url, $label);

        $this->assertEquals($expectedHtml, $html);
    }

    /** @test */
    public function it_generates_html_with_a_single_attribute_rule()
    {
        $url = '/';
        $label = 'Label';
        $attributeRule = array(array('htmlAttributes' => array('id=some_id', 'class=some_class')));

        $expectedHtml = $this->getFilledDefaultTemplate($url, $label, 'class="some_class" id="some_id"');

        $html = $this->generator->generateItemHtml($url, $label, $attributeRule);

        $this->assertEquals($expectedHtml, $html);
    }

    /** @test */
    public function it_generates_html_with_multiple_class_rules()
    {
        $url = '/';
        $label = 'Label';
        $attributeRules = array(
            array('htmlAttributes' => array('id=some_id', 'class=some_class')),
            array('htmlAttributes' => array('class=some_other_class'))
        );

        $expectedHtml = $this->getFilledDefaultTemplate($url, $label, 'class="some_class some_other_class" id="some_id"');

        $html = $this->generator->generateItemHtml($url, $label, $attributeRules);

        $this->assertEquals($expectedHtml, $html);
    }

} 