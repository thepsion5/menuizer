<?php

/**
 * @group Helper
 */
class StrToAssocArrayTest extends TestCase
{
    /** @test */
    public function it_breaks_a_string_into_an_associative_array()
    {
        $testString = 'param1=value1,param2=value2,param3=value3';
        $expected = array(
            'param1' => 'value1',
            'param2' => 'value2',
            'param3' => 'value3'
        );
        $result = str_to_assoc_array(',', '=', $testString);

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

        $result = str_to_assoc_array(',', '=', $testString);

        $this->assertEquals($expected, $result);
    }
}
