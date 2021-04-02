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

use Nfigurator\Directive;
use Nfigurator\Exception;
use Nfigurator\Scope;
use PHPUnit\Framework\TestCase;

class ScopeTest extends TestCase
{

    public function testFromFile()
    {
        Scope::fromFile(__DIR__.'/test_input.conf')->saveToFile(__DIR__.'/out.conf');
        $this->assertEquals(@file_get_contents(__DIR__.'/test_input.conf'), @file_get_contents(__DIR__.'/out.conf'));
    }

    public function testSaveToFile()
    {
        $this->expectException(\Nfigurator\Exception::class);

        $scope = new Scope();
        $scope->saveToFile('this/path/does/not/exist.conf');
    }

    public function testCreate()
    {
        $config_string = (string) Scope::create()
            ->addDirective(Directive::create('server')
                ->setChildScope(Scope::create()
                    ->addDirective(Directive::create('listen', 8080))
                    ->addDirective(Directive::create('server_name', 'example.net'))
                    ->addDirective(Directive::create('root', 'C:/www/example_net'))
                    ->addDirective(Directive::create('location', '^~ /var/', Scope::create()
                        ->addDirective(Directive::create('deny', 'all'))
                    )->setCommentText('Deny access for location /var/')
                    )
                )
            )->__toString();
        $this->assertEquals($config_string, @file_get_contents(__DIR__.'/scope_create_output.conf'));
    }

    /** @test */
    public function testCanAddNewline()
    {
        $config = (string) Scope::create()
            ->addDirective(Directive::create('server')
                ->setChildScope(Scope::create()->addNewline()));


        $this->assertEquals("server {

}
", (string) $config);

    }


}
