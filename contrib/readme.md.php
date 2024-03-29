<?php /** @var \DocGen $generator */ ?>
<?php echo $generator->getOverwriteWarning(); ?>
<?php $componentSupport = $generator->getComponentSupport(); ?>


# PHPDocker

[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%205.6-8892BF.svg)](https://php.net/)
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](https://raw.githubusercontent.com/uuf6429/rune/master/LICENSE)
<?php
    if (is_array($componentSupport)) {
        foreach ($componentSupport as $component) {
            printf(
                '[![%s](https://img.shields.io/badge/%s-%s-0db7ed.svg)](%s)%s',
                $component->name,
                substr($component->shortName, 0, 1),
                round($component->supportPercent) . '%25', // %25 is url-encoded %
                '#supported-commands',
                "\n"
            );
        }
    }
?>

PHP library providing a simple API for [Docker cli](https://docs.docker.com/engine/reference/commandline/cli/).

## Table of Contents

- [PHPDocker](#phpdocker)
  - [Table of Contents](#table-of-contents)
  - [Why?](#why)
  - [Installation](#installation)
  - [Usage](#usage)
  - [Supported Commands](#supported-commands)
  - [Documentation](#documentation)

## Why?

Many operations in Docker are exposed via a [REST API](https://docs.docker.com/engine/api/latest/), however, some commands (eg, `docker-compose`) cannot be used from the API (because `docker-compose` itself uses the low-level API).
Additionally, if you use the REST API, you'll end up doing what the Docker cli is already doing for you.
In some cases it makes sense to use the low-level API, in which case you can use [another PHP library](https://github.com/docker-php/docker-php).

If, however, all you want is to jump in and start using Docker from your PHP application, this library fits the purpose well.

**TL:DR;**
- why not?
- supports more functionality _(eg; `docker-toolbox`)_
- fixes common issues _(eg; Docker from Docker Toolbox misses configuration and refuses to run outside of the Quickstart Terminal)_

## Installation

First [install Composer](https://getcomposer.org/download/) and then run the following command in your project directory:

```bash
composer require uuf6429/phpdocker
```

## Usage

This library requires either [native Docker](https://www.docker.com/community-edition#download) or [Docker Toolbox](https://docs.docker.com/toolbox/overview/).

Two interfaces are provided, both of which start with the [Manager](<?=$generator->getDocsPath(); ?>#phpdockermanager) class:

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

<?php if (is_array($componentSupport)) {
    $bulletCheck = "\xE2\x9C\x85";
    $bulletQuest = "&nbsp;&nbsp;\x3F&nbsp;&nbsp;";
    $bulletCross = "\xE2\x9D\x8C";
    $bulletAster = "&nbsp;\xE2\x9C\xB1&nbsp;"; ?>
- <?=$bulletCheck; ?> _Fully implemented._
- <?=$bulletQuest; ?> _Incomplete (check method for details)._
- <?=$bulletCross; ?> _Not implemented yet._
- <?=$bulletAster; ?> _Not (and won't be) implemented._

<table>
    <thead>
<?php
    foreach ($componentSupport as $component) {
        printf(
            '<th>%s (%s%%)</th>',
            $component->name,
            round($component->supportPercent)
        );
    } ?>

    </thead><tbody>
        <tr>
<?php foreach ($componentSupport as $component) {
        ?>
            <td valign="top">
<?php
        foreach ($component->commands as $command) {
            echo '                ';
            echo $command->isSupported
                ? ($command->isIncomplete ? $bulletQuest : $bulletCheck)
                : ($command->isIgnored ? $bulletAster : $bulletCross);
            echo $command->isSupported
                ? sprintf(' <a href="%s" title="%s">%s</a><br/>', $command->methodLink, $command->methodText, $command->fqCommandName)
                : sprintf(' %s<br/>', $command->fqCommandName);
            echo "\n";
        } ?>
            </td>
<?php
    } ?>
        </tr>
    </tbody>
</table>
<?php
} else {
        ?>
<?php echo "```text\n\xE2\x9A\xA0 $componentSupport\n```\n"; ?>
<?php
    } ?>

## [Documentation](<?=$generator->getDocsPath(); ?>)

Complete up-to-date API documentation can be found [here](<?=$generator->getDocsPath(); ?>).
