<?php

namespace Tests\Feature;

use Nfigurator\Exception;
use Nfigurator\Scope;
use PHPUnit\Framework\TestCase;

/**
 * FullExample test shouldnt be too picky, there is some syntactic shuffling with spaces for newlines replacing
 * feature test is more aimed to check if a real life example can be parsed and reassembled again
 */
class FullExampleTest extends TestCase
{
    public function testFullExample()
    {
        $fullExample = Scope::fromFile(__DIR__.'/../full_nginx_example.conf');

        $fullContent = $this->replaceDoubleSpaces(file_get_contents(__DIR__.'/../full_nginx_example.conf'));
        $fullContent = $this->replaceDoubleComments($fullContent) . ' ';

        $fullExample = $this->replaceDoubleSpaces((string) $fullExample);

        $this->assertEquals($fullExample, $fullContent );
    }

    /**
     * @param string $input
     * @return string
     */
    private function replaceDoubleComments(string $input): string
    {
        if (strpos($input, '##') === false) {
            return $input;
        }

        $input = str_replace('##', '#', $input);

        return $this->replaceDoubleComments($input);
    }

    /**
     * @param string $input
     * @return string
     */
    private function scrapNewlines(string $input): string
    {
        return str_replace('\n', '', $input);
    }

    /**
     * @param string $input
     * @return string
     */
    private function replaceDoubleSpaces(string $input): string
    {
        return preg_replace('/\s+/', ' ', $input);
    }
}