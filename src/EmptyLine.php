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

class EmptyLine extends Printable
{
    public static function fromString(Text $configString)
    {
        $configString->gotoNextEol();
        return new self;
    }

    public function prettyPrint($indentLevel, $spacesPerIndent = 4)
    {
        return "\n";
    }
}