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

class Comment extends Printable
{
    /** @var string $text */
    private $text = null;

    public function __construct(?string $text = null)
    {
        $this->text = $text;
    }

    public static function fromString(Text $configString)
    {
        $text = '';
        while ((false === $configString->eof()) && (false === $configString->eol())) {
            $text .= $configString->getChar();
            $configString->inc();
        }
        return new Comment(ltrim($text, "# "));
    }

    /**
     * Get comment text
     *
     * @return string|null
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * Is this an empty (no text) comment?
     *
     * @return bool
     */
    public function isEmpty(): bool
    {
        return ((is_null($this->text)) || ('' === $this->text));
    }

    /**
     * Is this comment multi-line?
     *
     * @return bool
     */
    public function isMultiline(): bool
    {
        return (false !== strpos(rtrim($this->text), "\n"));
    }

    /**
     * Set the comment text
     *
     * If you set the comment text to null or empty string,
     * the comment will not print.
     *
     * @param string|null $text
     * @return self
     */
    public function setText(?string $text): self
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @param $indentLevel
     * @param int $spacesPerIndent
     * @return string
     */
    public function prettyPrint($indentLevel, $spacesPerIndent = 4): string
    {
        if (true === $this->isEmpty()) {
            return '';
        }

        $indent = str_repeat(str_repeat(' ', $spacesPerIndent), $indentLevel);
        $text = $indent . "# " . rtrim($this->text);

        if (true === $this->isMultiline()) {
            $text = preg_replace("#\r{0,1}\n#", PHP_EOL . $indent . "# ", $text);
        }

        return $text . "\n";
    }
}
