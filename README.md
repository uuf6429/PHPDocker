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

**Return Value:**

`bool`

----

#### `Manager::isInstalled()`

```php
$manager->isInstalled(): bool
```

**Return Value:**

`bool`

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
$machine->getActive($timeout): string
```

Returns name of active machine.

**Arguments:**

| Parameter             | Type          | Description |
|-----------------------|---------------|-------------|
| <code>$timeout</code> |               |             |

**Return Value:**

`string`

----

#### `Machine::getCommands()`

```php
$machine->getCommands(string[] $parentCommands): array
```

Caution! This method gives a rough idea of functionality as reported by the console
app, however the program itself could support a different set of commands.

**Arguments:**

| Parameter                    | Type                  | Description                                                      |
|------------------------------|-----------------------|------------------------------------------------------------------|
| <code>$parentCommands</code> | <code>string[]</code> | get sub-commands of this command path (mostly internal use only) |

**Return Value:**

`array` - the key is the command, the value is the description

----

#### `Machine::getIPs()`

```php
$machine->getIPs(null|string[] $machineNames): string|string[]
```

Returns IP of default machine (if $names is null), otherwise IPs of the specified machines.

**Arguments:**

| Parameter                  | Type                       | Description |
|----------------------------|----------------------------|-------------|
| <code>$machineNames</code> | <code>null&#124;string[]</code> |             |

**Return Value:**

`string|string[]` - IP of default machine or an array of IPs for the specified machines

----

#### `Machine::getVersion()`

```php
$machine->getVersion(): string
```

**Return Value:**

`string`

----

#### `Machine::isInstalled()`

```php
$machine->isInstalled(): bool
```

**Return Value:**

`bool`

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
$docker->copy(string $containerName, string $sourcePath, string $targetPath): $this
```

**Arguments:**

| Parameter                   | Type                | Description |
|-----------------------------|---------------------|-------------|
| <code>$containerName</code> | <code>string</code> |             |
| <code>$sourcePath</code>    | <code>string</code> |             |
| <code>$targetPath</code>    | <code>string</code> |             |

**Return Value:**

`$this`

----

#### `Docker::getCommands()`

```php
$docker->getCommands(string[] $parentCommands): array
```

Caution! This method gives a rough idea of functionality as reported by the console
app, however the program itself could support a different set of commands.

**Arguments:**

| Parameter                    | Type                  | Description                                                      |
|------------------------------|-----------------------|------------------------------------------------------------------|
| <code>$parentCommands</code> | <code>string[]</code> | get sub-commands of this command path (mostly internal use only) |

**Return Value:**

`array` - the key is the command, the value is the description

----

#### `Docker::getVersion()`

```php
$docker->getVersion(): string
```

**Return Value:**

`string`

----

#### `Docker::isInstalled()`

```php
$docker->isInstalled(): bool
```

**Return Value:**

`bool`

----

#### `Docker::setDockerFile()`

```php
$docker->setDockerFile(string $dockerFile): $this
```

**Arguments:**

| Parameter                | Type                | Description |
|--------------------------|---------------------|-------------|
| <code>$dockerFile</code> | <code>string</code> |             |

**Return Value:**

`$this`

----

#### `Docker::withFile()`

```php
$docker->withFile(string $dockerFile): $this
```

**Arguments:**

| Parameter                | Type                | Description |
|--------------------------|---------------------|-------------|
| <code>$dockerFile</code> | <code>string</code> |             |

**Return Value:**

`$this`

### PHPDocker\Component\Compose

- Full name: PHPDocker\Component\Compose
- Extends: PHPDocker\Component\Component

----

#### `Compose::build()`

```php
$compose->build(null $file, bool $noCache, bool $forceRemove, bool $forcePull)
```

**Arguments:**

| Parameter                 | Type              | Description |
|---------------------------|-------------------|-------------|
| <code>$file</code>        | <code>null</code> |             |
| <code>$noCache</code>     | <code>bool</code> |             |
| <code>$forceRemove</code> | <code>bool</code> |             |
| <code>$forcePull</code>   | <code>bool</code> |             |

----

#### `Compose::clearCommandsCache()`

```php
$compose->clearCommandsCache()
```

Clears the cache holding the result of `getCommands()`.

----

#### `Compose::down()`

```php
$compose->down(null|string $file, null|string $removeImages, bool $removeVolumes)
```

**Arguments:**

| Parameter                   | Type                     | Description                                                      |
|-----------------------------|--------------------------|------------------------------------------------------------------|
| <code>$file</code>          | <code>null&#124;string</code> |                                                                  |
| <code>$removeImages</code>  | <code>null&#124;string</code> | 'local' or 'all', see `docker-compose down --help` for more info |
| <code>$removeVolumes</code> | <code>bool</code>        |                                                                  |

----

#### `Compose::getCommands()`

```php
$compose->getCommands(string[] $parentCommands): array
```

Caution! This method gives a rough idea of functionality as reported by the console
app, however the program itself could support a different set of commands.

**Arguments:**

| Parameter                    | Type                  | Description                                                      |
|------------------------------|-----------------------|------------------------------------------------------------------|
| <code>$parentCommands</code> | <code>string[]</code> | get sub-commands of this command path (mostly internal use only) |

**Return Value:**

`array` - the key is the command, the value is the description

----

#### `Compose::getVersion()`

```php
$compose->getVersion(): string
```

**Return Value:**

`string`

----

#### `Compose::isInstalled()`

```php
$compose->isInstalled(): bool
```

**Return Value:**

`bool`

----

#### `Compose::remove()`

```php
$compose->remove($file, $stopContainers, $removeVolumes)
```

**Arguments:**

| Parameter                    | Type          | Description |
|------------------------------|---------------|-------------|
| <code>$file</code>           |               |             |
| <code>$stopContainers</code> |               |             |
| <code>$removeVolumes</code>  |               |             |

----

#### `Compose::setComposeFile()`

```php
$compose->setComposeFile(string $composeFile): $this
```

**Arguments:**

| Parameter                 | Type                | Description |
|---------------------------|---------------------|-------------|
| <code>$composeFile</code> | <code>string</code> |             |

**Return Value:**

`$this`

----

#### `Compose::withFile()`

```php
$compose->withFile(string $configFile): $this
```

**Arguments:**

| Parameter                | Type                | Description |
|--------------------------|---------------------|-------------|
| <code>$configFile</code> | <code>string</code> |             |

**Return Value:**

`$this`
