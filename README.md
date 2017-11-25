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
  - [API](#api)
    - [Manager](#phpdockermanager)
      - [`isDockerToolbox()`](#managerisdockertoolbox)
      - [`isInstalled()`](#managerisinstalled)
    - [Machine](#phpdockercomponentmachine)
      - [`clearCommandsCache()`](#machineclearcommandscache)
      - [`getActive()`](#machinegetactive)
      - [`getCommands()`](#machinegetcommands)
      - [`getIPs()`](#machinegetips)
      - [`getVersion()`](#machinegetversion)
      - [`isInstalled()`](#machineisinstalled)
    - [Docker](#phpdockercomponentdocker)
      - [`clearCommandsCache()`](#dockerclearcommandscache)
      - [`copy()`](#dockercopy)
      - [`getCommands()`](#dockergetcommands)
      - [`getVersion()`](#dockergetversion)
      - [`isInstalled()`](#dockerisinstalled)
      - [`setDockerFile()`](#dockersetdockerfile)
      - [`withFile()`](#dockerwithfile)
    - [Compose](#phpdockercomponentcompose)
      - [`build()`](#composebuild)
      - [`clearCommandsCache()`](#composeclearcommandscache)
      - [`down()`](#composedown)
      - [`getCommands()`](#composegetcommands)
      - [`getVersion()`](#composegetversion)
      - [`isInstalled()`](#composeisinstalled)
      - [`remove()`](#composeremove)
      - [`setComposeFile()`](#composesetcomposefile)
      - [`withFile()`](#composewithfile)

## Installation

## Usage

## API

### PHPDocker\Manager

- Full name: PHPDocker\Manager

----

#### `Manager::isDockerToolbox()`

```php
$manager->isDockerToolbox(): bool
```

----

#### `Manager::isInstalled()`

```php
$manager->isInstalled(): bool
```

### PHPDocker\Component\Machine

- Full name: PHPDocker\Component\Machine
- Extends: PHPDocker\Component\Component

----

#### `Machine::clearCommandsCache()`

```php
$machine->clearCommandsCache()
```

Clears the cache holding the result of `getCommands()`.

----

#### `Machine::getActive()`

```php
$machine->getActive(
    null|int $timeout    // Timeout in seconds.
): string    // Name of active machine.
```

Finds the currently active machine.

----

#### `Machine::getCommands()`

```php
$machine->getCommands(
    string[] $parentCommands    // get sub-commands of this command path (mostly internal use only)
): array    // the key is the command, the value is the description
```

Caution! This method gives a rough idea of functionality as reported by the console
app, however the program itself could support a different set of commands.

----

#### `Machine::getIPs()`

```php
$machine->getIPs(
    null|string[] $machineNames    // Names of desired machines or `null` for the default machine.
): string|string[]    // IP of default machine or an array of IPs for the specified machines
```

Returns IP of default machine (if $names is null), otherwise IPs of the specified machines.

----

#### `Machine::getVersion()`

```php
$machine->getVersion(): string
```

----

#### `Machine::isInstalled()`

```php
$machine->isInstalled(): bool
```

### PHPDocker\Component\Docker

- Full name: PHPDocker\Component\Docker
- Extends: PHPDocker\Component\Component

----

#### `Docker::clearCommandsCache()`

```php
$docker->clearCommandsCache()
```

Clears the cache holding the result of `getCommands()`.

----

#### `Docker::copy()`

```php
$docker->copy(
    string $containerName    // Name of the target container.
    string $sourcePath       // Source file or directory to copy.
    string $targetPath       // Destination where to copy to.
): $this    // Current instance, for method chaining.
```

----

#### `Docker::getCommands()`

```php
$docker->getCommands(
    string[] $parentCommands    // get sub-commands of this command path (mostly internal use only)
): array    // the key is the command, the value is the description
```

Caution! This method gives a rough idea of functionality as reported by the console
app, however the program itself could support a different set of commands.

----

#### `Docker::getVersion()`

```php
$docker->getVersion(): string
```

----

#### `Docker::isInstalled()`

```php
$docker->isInstalled(): bool
```

----

#### `Docker::setDockerFile()`

```php
$docker->setDockerFile(
    string $dockerFile    // Full file name to a '.dockerfile'.
): $this    // Current instance, for method chaining.
```

----

#### `Docker::withFile()`

```php
$docker->withFile(
    string $dockerFile    // Full file name to a '.dockerfile'.
): self    // New instance using the specified docker file.
```

### PHPDocker\Component\Compose

- Full name: PHPDocker\Component\Compose
- Extends: PHPDocker\Component\Component

----

#### `Compose::build()`

```php
$compose->build(
    null $file
    bool $noCache
    bool $forceRemove
    bool $forcePull
)
```

----

#### `Compose::clearCommandsCache()`

```php
$compose->clearCommandsCache()
```

Clears the cache holding the result of `getCommands()`.

----

#### `Compose::down()`

```php
$compose->down(
    null|string $file
    null|string $removeImages     // 'local' or 'all', see `docker-compose down --help` for more info
    bool        $removeVolumes
)
```

----

#### `Compose::getCommands()`

```php
$compose->getCommands(
    string[] $parentCommands    // get sub-commands of this command path (mostly internal use only)
): array    // the key is the command, the value is the description
```

Caution! This method gives a rough idea of functionality as reported by the console
app, however the program itself could support a different set of commands.

----

#### `Compose::getVersion()`

```php
$compose->getVersion(): string
```

----

#### `Compose::isInstalled()`

```php
$compose->isInstalled(): bool
```

----

#### `Compose::remove()`

```php
$compose->remove(
     $file
     $stopContainers
     $removeVolumes
)
```

----

#### `Compose::setComposeFile()`

```php
$compose->setComposeFile(
    string $composeFile
): $this
```

----

#### `Compose::withFile()`

```php
$compose->withFile(
    string $configFile
): $this
```
