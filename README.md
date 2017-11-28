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
      - [`getEnvVars()`](#machinegetenvvars)
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
      - [`execute()`](#composeexecute)
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

_extends `PHPDocker\Component\Component`_

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
    null|int $timeout    // timeout in seconds
): string    // name of active machine
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

#### `Machine::getEnvVars()`

```php
$machine->getEnvVars(
    null|string $machineName    // name of desired machine or `null` for the default machine
): array    // array of environment variables as key=>value pairs
```

Returns array of environment variables that must be set for docker to use a specific machine.

----

#### `Machine::getIPs()`

```php
$machine->getIPs(
    null|string[] $machineNames    // names of desired machines or `null` for the default machine
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

_extends `PHPDocker\Component\Component`_

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
    string $containerName    // name of the target container
    string $sourcePath       // source file or directory to copy
    string $targetPath       // destination where to copy to
): $this    // current instance, for method chaining
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
): $this    // current instance, for method chaining
```

----

#### `Docker::withFile()`

```php
$docker->withFile(
    string $dockerFile    // Full file name to a '.dockerfile'.
): self    // new instance using the specified docker file
```

### PHPDocker\Component\Compose

_extends `PHPDocker\Component\Component`_

----

#### `Compose::build()`

```php
$compose->build(
    bool $noCache
    bool $forceRemove
    bool $forcePull
): $this    // returns current instance, for method chaining
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
    null|string $removeImages     // either 'local' or 'all', see `docker-compose down --help` for more info
    bool        $removeVolumes    // true to remove volumes as well
): $this    // returns current instance, for method chaining
```

----

#### `Compose::execute()`

```php
$compose->execute(
    string      $service         // the name of the service from the docker file where the command will execute
    string      $command         // The command(s) to run. Multiple commands can be joined with '&&' (stop on first failure), '||' (stop on first success) or ';' (ignore failures) as appropriate.
    bool        $background      // runs the command in the background (command output won't be logged)
    bool        $isPrivileged
    null|string $asUser
    bool        $noTty           // disables pseudo-TTY (enabled by default since it's more often needed)
): $this    // returns current instance, for method chaining
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
    bool $stopContainers
    bool $removeVolumes
): $this    // returns current instance, for method chaining
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
