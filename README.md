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
      - [`withOutputHandler()`](#machinewithoutputhandler)
    - [Docker](#phpdockercomponentdocker)
      - [`attach()`](#dockerattach)
      - [`clearCommandsCache()`](#dockerclearcommandscache)
      - [`commit()`](#dockercommit)
      - [`copy()`](#dockercopy)
      - [`diff()`](#dockerdiff)
      - [`exec()`](#dockerexec)
      - [`export()`](#dockerexport)
      - [`find()`](#dockerfind)
      - [`getCommands()`](#dockergetcommands)
      - [`getVersion()`](#dockergetversion)
      - [`isInstalled()`](#dockerisinstalled)
      - [`kill()`](#dockerkill)
      - [`logs()`](#dockerlogs)
      - [`pause()`](#dockerpause)
      - [`port()`](#dockerport)
      - [`remove()`](#dockerremove)
      - [`rename()`](#dockerrename)
      - [`restart()`](#dockerrestart)
      - [`resume()`](#dockerresume)
      - [`run()`](#dockerrun)
      - [`start()`](#dockerstart)
      - [`stop()`](#dockerstop)
      - [`top()`](#dockertop)
      - [`update()`](#dockerupdate)
      - [`wait()`](#dockerwait)
      - [`withFile()`](#dockerwithfile)
      - [`withOutputHandler()`](#dockerwithoutputhandler)
    - [Compose](#phpdockercomponentcompose)
      - [`build()`](#composebuild)
      - [`clearCommandsCache()`](#composeclearcommandscache)
      - [`down()`](#composedown)
      - [`execute()`](#composeexecute)
      - [`getCommands()`](#composegetcommands)
      - [`getVersion()`](#composegetversion)
      - [`isInstalled()`](#composeisinstalled)
      - [`remove()`](#composeremove)
      - [`withFile()`](#composewithfile)
      - [`withOutputHandler()`](#composewithoutputhandler)

## Installation

## Usage

This library requires either [native Docker](https://www.docker.com/community-edition#download) or [Docker Toolbox](https://docs.docker.com/toolbox/overview/).

Two interfaces are provided, both of which start with the [Manager](#phpdockermanager) class:

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

----

#### `Machine::withOutputHandler()`

```php
$machine->withOutputHandler(
    callable $outputHandler
): static    // new instance using the specified output handler
```

### PHPDocker\Component\Docker

_extends `PHPDocker\Component\Component`_

----

#### `Docker::attach()`

```php
$docker->attach()
```

----

#### `Docker::clearCommandsCache()`

```php
$docker->clearCommandsCache()
```

Clears the cache holding the result of `getCommands()`.

----

#### `Docker::commit()`

```php
$docker->commit()
```

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

#### `Docker::diff()`

```php
$docker->diff()
```

----

#### `Docker::exec()`

```php
$docker->exec()
```

----

#### `Docker::export()`

```php
$docker->export()
```

----

#### `Docker::find()`

```php
$docker->find(
    string $containerName
): \Container
```

Returns an object representing a container given the container name.

Note that the container might not exist at this or any point, so you should call exists().

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

#### `Docker::kill()`

```php
$docker->kill()
```

----

#### `Docker::logs()`

```php
$docker->logs()
```

----

#### `Docker::pause()`

```php
$docker->pause()
```

----

#### `Docker::port()`

```php
$docker->port()
```

----

#### `Docker::remove()`

```php
$docker->remove(
    string|string[] $containerNames    // either the container name as a string or a list of container names
    bool            $forceRemove       // if true, the container will be removed forcefully, even if it is running
    bool            $removeVolumes     // if trues, also remove volumes associated to container
): $this
```

Removes one or more containers given names.

----

#### `Docker::rename()`

```php
$docker->rename()
```

----

#### `Docker::restart()`

```php
$docker->restart()
```

----

#### `Docker::resume()`

```php
$docker->resume()
```

----

#### `Docker::run()`

```php
$docker->run(
    string       $image            // name of docker image
    null|string  $containerName    // name of the container (so you can find() it later on)
    array        $containerCmd     // Array of command (first item) and arguments (every other item) to execute in container
    bool         $background       // True to run container in the background.
Important! If you want container to keep running after your code ends, this must be true.
However, if set to true you won't be able to capture execution output directly.
    array        $envVars          // a list of key=>value pairs of environments to be used inside container
    array|string $portMap          // array with string keys - a list of key-value pairs for exposing ports (key is host, value is container) eg; ['3306' => '3306']
array with integer keys - a list of port map specification strings (see docker documentation for specification) eg; ['3306:3306']
self::ALL_PORTS - exposes all exported ports (--publish-all=true) randomly
): $this
```

Creates a new container from an image and (optionally) runs a command in it.

----

#### `Docker::start()`

```php
$docker->start()
```

----

#### `Docker::stop()`

```php
$docker->stop()
```

----

#### `Docker::top()`

```php
$docker->top()
```

----

#### `Docker::update()`

```php
$docker->update()
```

----

#### `Docker::wait()`

```php
$docker->wait()
```

----

#### `Docker::withFile()`

```php
$docker->withFile(
    string $dockerFile    // Full file name to a '.dockerfile'.
): self    // new instance using the specified docker file
```

----

#### `Docker::withOutputHandler()`

```php
$docker->withOutputHandler(
    callable $outputHandler
): static    // new instance using the specified output handler
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

#### `Compose::withFile()`

```php
$compose->withFile(
    string $configFile    // Full file name to a 'docker-compose.yml'.
): self    // new instance using the specified docker compose file
```

----

#### `Compose::withOutputHandler()`

```php
$compose->withOutputHandler(
    callable $outputHandler
): static    // new instance using the specified output handler
```
