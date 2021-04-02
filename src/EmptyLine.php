<?php

/**
 * This file is part of the Nginx Config Processor package.
 *
 * (c) Michael Tiel <michael@tiel.dev>
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
    /**
     * @param Text $configString
     * @return static
     */
    public static function fromString(Text $configString): self
    {
        $configString->gotoNextEol();
        return new self;
    }

    /**
     * @param int $indentLevel
     * @param int $spacesPerIndent
     * @return string
     */
    public function prettyPrint(int $indentLevel, int $spacesPerIndent = 4): string
    {
        return "\n";
    }
}