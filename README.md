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
    - [Machine](#phpdockercomponentmachine)
    - [Docker](#phpdockercomponentdocker)
    - [Compose](#phpdockercomponentcompose)

## Installation

## Usage

## API

### PHPDocker\Manager

- Full name: PHPDocker\Manager

#### isDockerToolbox()

```php
$manager->isDockerToolbox(): bool
```

##### Return Value:
`bool` - _No Description_

#### isInstalled()

```php
$manager->isInstalled(): bool
```

##### Return Value:
`bool` - _No Description_

### PHPDocker\Component\Machine

- Full name: PHPDocker\Component\Machine
- Extends: [PHPDocker\Component\Component](#phpdockercomponentcomponent)

#### clearCommandsCache()

```php
$machine->clearCommandsCache()
```

Clears the cache holding the result of `getCommands()`.

#### getActive()

```php
$machine->getActive( $timeout): string
```

Returns name of active machine.

##### Arguments:
| Parameter  | Type | Description |
|------------|------|-------------|
| `$timeout` | ``   |             |

##### Return Value:
`string` - _No Description_

#### getCommands()

```php
$machine->getCommands(string[] $parentCommands): array
```

Caution! This method gives a rough idea of functionality as reported by the console
app, however the program itself could support a different set of commands.

##### Arguments:
| Parameter         | Type       | Description                                                      |
|-------------------|------------|------------------------------------------------------------------|
| `$parentCommands` | `string[]` | get sub-commands of this command path (mostly internal use only) |

##### Return Value:
`array` - the key is the command, the value is the description

#### getIPs()

```php
$machine->getIPs(null|string[] $machineNames): string|string[]
```

Returns IP of default machine (if $names is null), otherwise IPs of the specified machines.

##### Arguments:
| Parameter       | Type            | Description |
|-----------------|-----------------|-------------|
| `$machineNames` | `null|string[]` |             |

##### Return Value:
`string|string[]` - IP of default machine or an array of IPs for the specified machines

#### getVersion()

```php
$machine->getVersion(): string
```

##### Return Value:
`string` - _No Description_

#### isInstalled()

```php
$machine->isInstalled(): bool
```

##### Return Value:
`bool` - _No Description_

### PHPDocker\Component\Docker

- Full name: PHPDocker\Component\Docker
- Extends: [PHPDocker\Component\Component](#phpdockercomponentcomponent)

#### clearCommandsCache()

```php
$docker->clearCommandsCache()
```

Clears the cache holding the result of `getCommands()`.

#### copy()

```php
$docker->copy(string $containerName, string $sourcePath, string $targetPath): $this
```

##### Arguments:
| Parameter        | Type     | Description |
|------------------|----------|-------------|
| `$containerName` | `string` |             |
| `$sourcePath`    | `string` |             |
| `$targetPath`    | `string` |             |

##### Return Value:
`$this` - _No Description_

#### getCommands()

```php
$docker->getCommands(string[] $parentCommands): array
```

Caution! This method gives a rough idea of functionality as reported by the console
app, however the program itself could support a different set of commands.

##### Arguments:
| Parameter         | Type       | Description                                                      |
|-------------------|------------|------------------------------------------------------------------|
| `$parentCommands` | `string[]` | get sub-commands of this command path (mostly internal use only) |

##### Return Value:
`array` - the key is the command, the value is the description

#### getVersion()

```php
$docker->getVersion(): string
```

##### Return Value:
`string` - _No Description_

#### isInstalled()

```php
$docker->isInstalled(): bool
```

##### Return Value:
`bool` - _No Description_

#### setDockerFile()

```php
$docker->setDockerFile(string $dockerFile): $this
```

##### Arguments:
| Parameter     | Type     | Description |
|---------------|----------|-------------|
| `$dockerFile` | `string` |             |

##### Return Value:
`$this` - _No Description_

#### withFile()

```php
$docker->withFile(string $dockerFile): $this
```

##### Arguments:
| Parameter     | Type     | Description |
|---------------|----------|-------------|
| `$dockerFile` | `string` |             |

##### Return Value:
`$this` - _No Description_

### PHPDocker\Component\Compose

- Full name: PHPDocker\Component\Compose
- Extends: [PHPDocker\Component\Component](#phpdockercomponentcomponent)

#### build()

```php
$compose->build(null $file, bool $noCache, bool $forceRemove, bool $forcePull)
```

##### Arguments:
| Parameter      | Type   | Description |
|----------------|--------|-------------|
| `$file`        | `null` |             |
| `$noCache`     | `bool` |             |
| `$forceRemove` | `bool` |             |
| `$forcePull`   | `bool` |             |

#### clearCommandsCache()

```php
$compose->clearCommandsCache()
```

Clears the cache holding the result of `getCommands()`.

#### down()

```php
$compose->down(null|string $file, null|string $removeImages, bool $removeVolumes)
```

##### Arguments:
| Parameter        | Type          | Description                                                      |
|------------------|---------------|------------------------------------------------------------------|
| `$file`          | `null|string` |                                                                  |
| `$removeImages`  | `null|string` | 'local' or 'all', see `docker-compose down --help` for more info |
| `$removeVolumes` | `bool`        |                                                                  |

#### getCommands()

```php
$compose->getCommands(string[] $parentCommands): array
```

Caution! This method gives a rough idea of functionality as reported by the console
app, however the program itself could support a different set of commands.

##### Arguments:
| Parameter         | Type       | Description                                                      |
|-------------------|------------|------------------------------------------------------------------|
| `$parentCommands` | `string[]` | get sub-commands of this command path (mostly internal use only) |

##### Return Value:
`array` - the key is the command, the value is the description

#### getVersion()

```php
$compose->getVersion(): string
```

##### Return Value:
`string` - _No Description_

#### isInstalled()

```php
$compose->isInstalled(): bool
```

##### Return Value:
`bool` - _No Description_

#### remove()

```php
$compose->remove( $file,  $stopContainers,  $removeVolumes)
```

##### Arguments:
| Parameter         | Type | Description |
|-------------------|------|-------------|
| `$file`           | ``   |             |
| `$stopContainers` | ``   |             |
| `$removeVolumes`  | ``   |             |

#### setComposeFile()

```php
$compose->setComposeFile(string $composeFile): $this
```

##### Arguments:
| Parameter      | Type     | Description |
|----------------|----------|-------------|
| `$composeFile` | `string` |             |

##### Return Value:
`$this` - _No Description_

#### withFile()

```php
$compose->withFile(string $configFile): $this
```

##### Arguments:
| Parameter     | Type     | Description |
|---------------|----------|-------------|
| `$configFile` | `string` |             |

##### Return Value:
`$this` - _No Description_

