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


class ParamsParser
{

    /**
     * @var string|null
     */
    private $value;

    /**
     * ParamsParser constructor.
     * @param string|null $value
     */
    public function __construct(?string $value)
    {
        $this->value = $value;
    }


    public function getParams(): array
    {
        if (! $this->value)  {
            return [];
        }

        $lines = preg_split("/\n/", $this->value, -1, 1);

        $results = [];
        foreach($lines as $lineNumber => $line)
        {
            $lineResults = $this->getSingleLineParams($line);
            if ($this->lastParamNeedsBreakline($lines, $lineNumber)) {
                /** @var Param $lastParam */
                $lastParam = $lineResults[count($lineResults) - 1];
                $lastParam->setAddBreak(true);
            }

            $results = array_merge($results, $lineResults);
        }


        return $results;
    }

    /**
     * @param array $lines
     * @param int $lineNumber
     * @return bool
     */
    private function lastParamNeedsBreakline(array $lines, int $lineNumber): bool
    {
        return $lineNumber < count($lines) - 1;
    }

    /**
     * @param string $value
     * @return array
     */
    private function getSingleLineParams(string $value): array
    {
        $splitted = preg_split("~'[^']*'(*SKIP)(*F)|\s+~", $value, -1, 1);

        $results = [];
        foreach($splitted as $item) {
            $results[] = Param::fromString($item);
        }

        return $results;
    }
}