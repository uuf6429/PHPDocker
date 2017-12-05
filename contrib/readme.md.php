<?php /** @var \DocGen $generator */ ?>
<?php echo $generator->getOverwriteWarning(); ?>


# PHPDocker

[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%205.6-8892BF.svg)](https://php.net/)
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](https://raw.githubusercontent.com/uuf6429/rune/master/LICENSE)

PHP library providing a simple API for [Docker cli](https://docs.docker.com/engine/reference/commandline/cli/).

## Table of Contents

- [PHPDocker](#phpdocker)
  - [Table of Contents](#table-of-contents)
  - [Installation](#installation)
  - [Usage](#usage)
  - [API](#api)
<?php
    foreach ($generator->getClasses() as $class) {
        echo "    - [{$class->name}](#{$class->titleLink})\n";
        foreach ($class->methods as $method) {
            if (!$method->isMagicMethod) {
                echo "      - [`{$method->name}()`](#{$method->titleLink})\n";
            }
        }
    }
?>

## Installation

## Usage

This library requires either [native Docker](https://www.docker.com/community-edition#download) or [Docker Toolbox](https://docs.docker.com/toolbox/overview/).

Two interfaces are provided, both of which start with the [Manager](#phpdockermanager) class:

- **Procedural**

  Everything can be done through the manager object and a whole process can be achieved through the use of method chaining.

  ```php
  $manager = new \PHPDocker\Manager();
  $manager->docker->run('some-image', 'my-service-name');

  // ... later on ...
  $manager->docker->stop('my-container-name');
  ```

- **Object Oriented**

  A reference object can be "created" for easy passing through your code while avoiding passing the manager object or state/config.

  The example below shows how one can save a reference to the running container and load it back later on to stop it (assuming the container is still running).

  ```php
  $manager = new \PHPDocker\Manager();
  $container = $manager->docker
      ->run('some-image', 'my-container-name')
      ->find('my-container-name');
  file_put_contents('cont1.txt', serialize($container));

  // ... later on ...
  $container = unserialize(file_get_contents('cont1.txt'));
  $container->stop('my-service-name');
  ```

**TL:DR;** In short, `->docker->%action%('xyz')` is equivalent to `->docker->find('xyz')->%action%()`.

## API
<?php
    foreach ($generator->getClasses() as $class) {
        echo "\n### {$class->titleText}\n";

        if ($class->hasParent || count($class->interfaceTextLinks)) {
            echo "\n_";

            if ($class->hasParent) {
                printf(
                    'extends %s',
                    $class->parentTitleLink
                        ? "[`{$class->parentTitleText}`](#{$class->parentTitleLink})"
                        : "`{$class->parentTitleText}`"
                );
            }

            if ($class->hasParent && count($class->interfaceTextLinks)) {
                echo '; ';
            }

            if (count($class->interfaceTextLinks)) {
                printf(
                    'implements %s',
                    implode(
                        ', ',
                        array_map(
                            function ($text, $link) {
                                return $link ? "[{$text}](#{$link})" : $text;
                            },
                            array_keys($class->interfaceTextLinks),
                            array_values($class->interfaceTextLinks)
                        )
                    )
                );
            }

            echo "_\n";
        }

        if ($class->description) {
            echo "\n{$class->description}\n\n";
        }

        foreach ($class->methods as $method) {
            if ($method->isMagicMethod) {
                continue;
            }

            echo "\n----\n";
            echo "\n#### {$method->titleText}\n";
            echo "\n```php\n$method->signature\n```\n";

            if ($method->description) {
                echo "\n{$method->description}\n";
            }
        }
    }
?>
