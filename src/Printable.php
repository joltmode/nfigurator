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

abstract class Printable
{
    /**
     * @param $indentLevel
     * @param int $spacesPerIndent
     * @return string
     */
    abstract public function prettyPrint(int $indentLevel, int $spacesPerIndent = 4): string;

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->prettyPrint(0);
    }
}