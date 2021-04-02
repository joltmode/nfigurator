<?php


namespace Tests;



use Nfigurator\Param;
use PHPUnit\Framework\TestCase;

class ParamTest extends TestCase
{


    public function testCanCreateParamWithoutLabel()
    {
        $text = "some_val";

        $param = Param::fromString($text);

        $this->assertNull($param->getLabel());
        $this->assertNotNull($param->getValue());

        $this->assertEquals("some_val", (string) $param);
    }

    public function testCanCreateParamWithLabel()
    {
        $text = "foo=bar";

        $param = Param::fromString($text);

        $this->assertNotNull($param->getLabel());
        $this->assertEquals("foo=bar", (string) $param);
    }


}