<?php


namespace Tests;


use Nfigurator\Param;
use Nfigurator\ParamsParser;
use PHPUnit\Framework\TestCase;

class ParamsParserTest extends TestCase
{
    public function testCanParseSingleParam()
    {
        $text = 'some_var';

        $paramsParser = new ParamsParser($text);
        $result = $paramsParser->getParams();


        $this->assertCount(1, $result);

        $this->assertInstanceOf(Param::class, $result[0]);
        $this->assertNull($result[0]->getLabel());

        $this->assertEquals('some_var', (string) $result[0]);
    }

    public function testCanParseMultiParams()
    {

        $text = 'some_var   aftersomespace';

        $paramsParser = new ParamsParser($text);

        $result = $paramsParser->getParams();

        $this->assertCount(2, $result);

        $this->assertInstanceOf(Param::class, $result[0]);
        $this->assertNull($result[0]->getLabel());

        $this->assertEquals('some_var', (string) $result[0]);
        $this->assertEquals('aftersomespace', (string) $result[1]);
    }

    public function testCanParseLabeledParams()
    {
        $text = 'foo=bar';

        $paramsParser = new ParamsParser($text);

        $result = $paramsParser->getParams();

        $this->assertCount(1, $result);

        $this->assertInstanceOf(Param::class, $result[0]);
        $this->assertEquals('foo', $result[0]->getLabel());
        $this->assertEquals('foo=bar', (string) $result[0]);
    }

    public function testWillLeaveStringLiterals()
    {
        $text = <<<'EOD'
main '$remote_addr - $remote_user [$time_local]  $status '
    '"$request" $body_bytes_sent "$http_referer" '
    '"$http_user_agent" "$http_x_forwarded_for"'
EOD;

        $paramsParser = new ParamsParser($text);

        $result = $paramsParser->getParams();

        $this->assertCount(4, $result);
        $this->assertInstanceOf(Param::class, $result[0]);

        $this->assertEquals("main", $result[0]->getValue());

        $this->assertEquals('\'$remote_addr - $remote_user [$time_local]  $status \''. "\n", (string) $result[1]);
        $this->assertEquals('\'"$request" $body_bytes_sent "$http_referer" \''. "\n", (string) $result[2]);
        $this->assertEquals('\'"$http_user_agent" "$http_x_forwarded_for"\'', (string) $result[3]);
    }



}