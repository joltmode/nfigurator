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


class Param
{
    /**
     * @var string
     */
    private $value;

    /**
     * @var string|null
     */
    private $label = null;

    private $addBreak = false;

    /**
     * Param constructor.
     * @param string $value
     * @param string|null $label
     */
    private function __construct(string $value, ?string $label)
    {
        $this->value = $value;
        $this->label = $label;
    }

    /**
     * @param string $input
     * @return Param
     */
    public static function fromString(string $input): Param
    {
        $parts = explode('=', $input, 2);
        $label = (count($parts) == 2) ? $parts[0] : null;

        return new self($parts[count($parts) - 1], $label);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        $toReturn = $this->value;
        if ($this->label) {
            $toReturn = $this->label . '=' . $this->value;
        }

        if ($this->addBreak) {
            $toReturn .= "\n";
        }

        return $toReturn;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @return string|null
     */
    public function getLabel(): ?string
    {
        return $this->label;
    }

    /**
     * @param bool $addBreak
     */
    public function setAddBreak(bool $addBreak): void
    {
        $this->addBreak = $addBreak;
    }


}