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

use Nfigurator\File;
use PHPUnit\Framework\TestCase;

class FileTest extends TestCase
{

    /**
     * Fail on non existing file
     *
     * @expectedException \Nfigurator\Exception
     */
    public function testCannotRead()
    {
        $this->expectException(\Nfigurator\Exception::class);
        new File('this_file_does_not_exist.txt');
    }

}
