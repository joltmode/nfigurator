<?php

/**
 * This file is part of the Nginx Config Processor package.
 *
 * (c) Toms Seisums
 * (c) Roman Piták <roman@pitak.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */

namespace Tests;

use Nfigurator\Text;
use PHPUnit\Framework\TestCase;

class TextTest extends TestCase
{

    public function testGetCharPosition()
    {
        $this->expectException(\Nfigurator\Exception::class);

        $text = new Text('');
        $text->getChar(1.5);
    }

    public function testGetCharEof()
    {
        $this->expectException(\Nfigurator\Exception::class);

        $text = new Text('');
        $text->getChar(1);
    }

    public function testGetLastEol()
    {
        $text = new Text('');
        $this->assertEquals(0, $text->getLastEol());
    }

    public function testGetNextEol()
    {
        $text = new Text("\n");
        $this->assertEquals(0, $text->getNextEol());
        $text = new Text("roman");
        $this->assertEquals(4, $text->getNextEol());
    }

}
