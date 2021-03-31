<?php


namespace Tests;


use Nfigurator\Directive;
use Nfigurator\Text;
use PHPUnit\Framework\TestCase;

class DirectiveTest extends TestCase
{
    public function testCanCreateDirectiveWithoutScope()
    {
        $line = "http https;";

        $directive = Directive::fromString(new Text($line));

        $this->assertNull($directive->getChildScope());
        $this->assertFalse($directive->hasComment());
    }

    public function testCanCreateDirectiveWithScope()
    {
        $line = "listen { 
        port 80; 
        }";

        $directive = Directive::fromString(new Text($line));

        $this->assertNotNull($directive->getChildScope());

        $this->assertEquals("port 80;\n\n", (string) $directive->getChildScope());
    }
}