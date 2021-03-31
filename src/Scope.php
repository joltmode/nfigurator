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

class Scope extends Printable
{
    /** @var Directive $parentDirective */
    private $parentDirective = null;

    /** @var Directive[] $directives */
    private $directives = array();

    /** @var Printable[] $printables */
    private $printables = array();

    /**
     * Write this Scope into a file.
     *
     * @param $filePath
     * @throws Exception
     */
    public function saveToFile($filePath): void
    {
        $handle = @fopen($filePath, 'w');
        if (false === $handle) {
            throw new Exception('Cannot open file "' . $filePath . '" for writing.');
        }

        $bytesWritten = @fwrite($handle, (string)$this);
        if (false === $bytesWritten) {
            fclose($handle);
            throw new Exception('Cannot write into file "' . $filePath . '".');
        }

        $closed = @fclose($handle);
        if (false === $closed) {
            throw new Exception('Cannot close file handle for "' . $filePath . '".');
        }
    }

    /*
     * ========== Factories ==========
     */

    /**
     * Provides fluid interface.
     *
     * @return Scope
     */
    public static function create(): self
    {
        return new self();
    }

    /**
     * Create new Scope from the configuration string.
     *
     * @param \RomanPitak\Nginx\Config\Text $configString
     * @return Scope
     * @throws Exception
     */
    public static function fromString(Text $configString)
    {
        $scope = new Scope();
        while (false === $configString->eof()) {

            if (true === $configString->isEmptyLine()) {
                $scope->addPrintable(EmptyLine::fromString($configString));
            }

            $char = $configString->getChar();

            if ('#' === $char) {
                $scope->addPrintable(Comment::fromString($configString));
                continue;
            }

            if (('a' <= $char) && ('z' >= $char)) {
                $scope->addDirective(Directive::fromString($configString));
                continue;
            }

            if ('}' === $configString->getChar()) {
                break;
            }

            $configString->inc();
        }
        return $scope;
    }

    /**
     * Create new Scope from a file.
     *
     * @param $filePath
     * @return Scope
     */
    public static function fromFile($filePath): self
    {
        return self::fromString(new File($filePath));
    }

    /*
     * ========== Getters ==========
     */

    /**
     * Get parent Directive.
     *
     * @return Directive|null
     */
    public function getParentDirective(): ?Directive
    {
        return $this->parentDirective;
    }

    /**
     * Get directives.
     *
     * @return Directive[]
     */
    public function getDirectives(): array
    {
        return $this->directives;
    }

    /*
     * ========== Setters ==========
     */

    /**
     * Add a Directive to the list of this Scopes directives
     *
     * Adds the Directive and sets the Directives parent Scope to $this.
     *
     * @param Directive $directive
     * @return $this
     */
    public function addDirective(Directive $directive): self
    {
        if ($directive->getParentScope() !== $this) {
            $directive->setParentScope($this);
        }

        $this->directives[] = $directive;
        $this->addPrintable($directive);

        return $this;
    }


    public function addNewline(): self
    {
        $this->addPrintable(new EmptyLine());

        return $this;
    }

    /**
     * Add printable element.
     *
     * @param Printable $printable
     */
    private function addPrintable(Printable $printable)
    {
        $this->printables[] = $printable;
    }

    /**
     * Set parent directive for this Scope.
     *
     * Sets parent directive for this Scope and also
     * sets the $parentDirective->setChildScope($this)
     *
     * @param Directive $parentDirective
     * @return $this
     */
    public function setParentDirective(Directive $parentDirective)
    {
        $this->parentDirective = $parentDirective;

        if ($parentDirective->getChildScope() !== $this) {
            $parentDirective->setChildScope($this);
        }

        return $this;
    }

    /*
     * ========== Printable ==========
     */

    /**
     * @inheritDoc
     */
    public function prettyPrint($indentLevel, $spacesPerIndent = 4): string
    {
        $resultString = "";
        foreach ($this->printables as $printable) {
            $resultString .= $printable->prettyPrint($indentLevel + 1, $spacesPerIndent);
        }

        return $resultString;
    }

    public function __toString(): string
    {
        return $this->prettyPrint(-1);
    }
}
