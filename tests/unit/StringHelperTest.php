<?php
/**
 * Created by PhpStorm.
 * User: Sean
 * Date: 5/14/14
 * Time: 11:21 AM
 */

namespace Thepsion5\Menuizer\Tests\Unit;

use Thepsion5\Menuizer\StringHelper;

class StringHelperTest extends \Thepsion5\Menuizer\Tests\TestCase
{
    /** @test */
    public function str_splice_splices_the_characters_before_the_delimiter_from_a_string()
    {
        $test = 'foo:bar';

        $spliced = StringHelper::splice(':', $test);

        $this->assertEquals('foo', $spliced);
        $this->assertEquals('bar', $test);
    }

    /** @test */
    public function str_splice_returns_null_if_the_delimiter_is_not_found()
    {
        $test = 'foobar';

        $spliced = StringHelper::splice(':', $test);

        $this->assertNull($spliced);
        $this->assertEquals('foobar', $test);
    }

    /** @test */
    public function str_splice_returns_the_first_characters_if_multiple_delimiters_found()
    {
        $test = 'foo:bar:baz';

        $spliced = StringHelper::splice(':', $test);

        $this->assertEquals('foo', $spliced);
        $this->assertEquals('bar:baz', $test);
    }

    public function it_breaks_a_string_into_an_associative_array()
    {
        $testString = 'param1=value1,param2=value2,param3=value3';
        $expected = array(
            'param1' => 'value1',
            'param2' => 'value2',
            'param3' => 'value3'
        );
        $result = StringHelper::toAssociativeArray($testString, ',', '=');

        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function it_creates_a_numeric_array_when_the_value_delimiter_is_not_found()
    {
        $testString = 'param1>value1,param2?value2,param3=value3';
        $expected = array(
            'param1>value1',
            'param2?value2',
            'param3' => 'value3'
        );

        $result = StringHelper::toAssociativeArray($testString, ',', '=');

        $this->assertEquals($expected, $result);
    }
} 