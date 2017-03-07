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

namespace Nfigurator;

use PHPUnit\Framework\TestCase;

class EmptyLineTest extends TestCase
{

    public function testCanBeConstructed()
    {
        $emptyLine = new EmptyLine();
        $this->assertInstanceOf('\\Nfigurator\\EmptyLine', $emptyLine);
        return $emptyLine;
    }

    /**
     * @depends testCanBeConstructed
     *
     * @param EmptyLine $emptyLine
     */
    public function testPrettyPrint(EmptyLine $emptyLine)
    {
        $this->assertEquals("\n", $emptyLine->prettyPrint(0));
    }

}
