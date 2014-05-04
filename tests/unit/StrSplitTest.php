<?php

/**
 * @group Helper
 */
class StrSplitTest extends TestCase
{

    /** @test */
    public function str_splice_splices_the_characters_before_the_delimiter_from_a_string()
    {
        $test = 'foo:bar';

        $spliced = str_splice(':', $test);

        $this->assertEquals('foo', $spliced);
        $this->assertEquals('bar', $test);
    }

    /** @test */
    public function str_splice_returns_null_if_the_delimiter_is_not_found()
    {
        $test = 'foobar';

        $spliced = str_splice(':', $test);

        $this->assertNull($spliced);
        $this->assertEquals('foobar', $test);
    }

    /** @test */
    public function str_splice_returns_the_first_characters_if_multiple_delimiters_found()
    {
        $test = 'foo:bar:baz';

        $spliced = str_splice(':', $test);

        $this->assertEquals('foo', $spliced);
        $this->assertEquals('bar:baz', $test);
    }

}
