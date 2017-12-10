<!-- This file is generated automatically and any changes will be overwritten! -->

# PHPDocker

[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%205.6-8892BF.svg)](https://php.net/)
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](https://raw.githubusercontent.com/uuf6429/rune/master/LICENSE)

PHP library providing a simple API for [Docker cli](https://docs.docker.com/engine/reference/commandline/cli/).

## Table of Contents

- [PHPDocker](#phpdocker)
  - [Table of Contents](#table-of-contents)
  - [Installation](#installation)
  - [Usage](#usage)
  - [Supported Commands](#supported-commands)
  - [Documentation](#documentation)

## Installation

First [install Composer](https://getcomposer.org/download/) and then run the following command in your project directory:

```bash
composer require uuf6429/phpdocker
```

## Usage

This library requires either [native Docker](https://www.docker.com/community-edition#download) or [Docker Toolbox](https://docs.docker.com/toolbox/overview/).

Two interfaces are provided, both of which start with the [Manager](/DOCS.md#phpdockermanager) class:

- **Procedural**

  Everything can be done through the manager object and a whole process can be achieved through the use of method chaining.

  ```php
  $manager = new \PHPDocker\Manager();
  $manager->docker->run('some-image', 'my-container');

  // ... later on ...
  $manager->docker->stop('my-container');
  ```

- **Object Oriented**

  A reference object can be "created" for easy passing through your code while avoiding passing the manager object or state/config.

  The example below shows how one can save a reference to the running container and load it back later on to stop it (assuming the container is still running).

  ```php
  $manager = new \PHPDocker\Manager();
  $container = $manager->docker
      ->run('some-image', 'my-container')
      ->find('my-container');
  file_put_contents('cont1.txt', serialize($container));

  // ... later on ...
  $container = unserialize(file_get_contents('cont1.txt'));
  $container->stop();
  ```

**TL:DR;** In short, `->docker->%action%('xyz')` is equivalent to `->docker->find('xyz')->%action%()`.

## Supported Commands

```text
⚠ ReflectionException: Property PHPDocker\Component\Docker::$bin does not exist in C:\Users\Christian\Documents\GitHub\PHPDocker\contrib\DocGen.php:361
Stack trace:
#0 C:\Users\Christian\Documents\GitHub\PHPDocker\contrib\DocGen.php(361): ReflectionProperty->__construct(Object(PHPDocker\Component\Docker), 'bin')
#1 C:\Users\Christian\Documents\GitHub\PHPDocker\contrib\DocGen.php(108): DocGen->buildCommandSupport(Object(PHPDocker\Component\Docker), 'docker')
#2 [internal function]: DocGen->{closure}('docker')
#3 C:\Users\Christian\Documents\GitHub\PHPDocker\contrib\DocGen.php(125): array_map(Object(Closure), Array)
#4 C:\Users\Christian\Documents\GitHub\PHPDocker\contrib\readme.md.php(3): DocGen->getComponentSupport()
#5 C:\Users\Christian\Documents\GitHub\PHPDocker\contrib\DocGen.php(475): require_once('C:\\Users\\Christ...')
#6 {main}
```

## [Documentation](/DOCS.md)

Complete up-to-date API documentation can be found [here](/DOCS.md).
