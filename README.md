# Nfigurator
## NGINX Configuration Processor

[![Latest Stable Version](https://img.shields.io/packagist/v/joltmode/nfigurator.svg)](https://packagist.org/packages/joltmode/nfigurator)
[![Total Downloads](https://img.shields.io/packagist/dt/joltmode/nfigurator.svg)](https://packagist.org/packages/joltmode/nfigurator)
[![License](https://img.shields.io/packagist/l/joltmode/nfigurator.svg)](https://packagist.org/packages/joltmode/nfigurator)
[![Build Status](https://img.shields.io/travis/joltmode/nfigurator/master.svg)](https://travis-ci.org/joltmode/nfigurator)
[![Code Climate](https://img.shields.io/codeclimate/github/joltmode/nfigurator.svg)](https://codeclimate.com/github/joltmode/nfigurator)
[![Test Coverage](https://img.shields.io/codeclimate/coverage/joltmode/nfigurator.svg)](https://codeclimate.com/github/joltmode/nfigurator/coverage)
[![Codacy Grade Badge](https://img.shields.io/codacy/grade/55153261fcf7497cbc1335484132dc78.svg)](https://www.codacy.com/app/joltmode/nfigurator)
[![Codacy Coverage Badge](https://img.shields.io/codacy/coverage/55153261fcf7497cbc1335484132dc78.svg)](https://www.codacy.com/app/joltmode/nfigurator)

(c) 2017 Toms Seisums  
(c) 2014-2016 [Roman Piták](http://pitak.net) <roman@pitak.net>

PHP Nginx configuration files processor (parser, creator).

## Installation

The best way to install is to use the [Composer](https://getcomposer.org/) dependency manager.

```
php composer.phar require joltmode/nfigurator
```

## Features

### Pretty Print

```php
<?php Scope::fromFile('m1.conf')->saveToFile('out.conf');
```

### Config Create

```php
<?php
Scope::create()
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
    )
    ->saveToFile('example.net');
```

File _example.net_:

```nginx
server {
    listen 8080;
    server_name example.net;
    root C:/www/example_net;
    location ^~ /var/ { # Deny access for location /var/
        deny all;
    }
}
```

### Comments handling

#### Simple comments

```php
<?php echo new Comment("This is a simple comment.");
```

output:

```nginx
# This is a simple comment.
```

#### Multi-line comments

```php
<?php
echo new Comment("This \nis \r\na multi
line " . PHP_EOL . "comment.");
```

output:

```nginx
# This
# is
# a multi
# line
# comment.
```

#### Directive with a simple comment

```php
<?php echo Directive::create('deny', 'all')->setCommentText('Directive with a comment');
```

output:

```nginx
deny all; # Directive with a comment
```

#### Directive with a multi-line comment

```php
<?php echo Directive::create('deny', 'all')->setCommentText('Directive
with a multi line comment');
```

output:

```nginx
# Directive
# with a multi line comment
deny all;
```
