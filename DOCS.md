<!-- This file is generated automatically and any changes will be overwritten! -->

# Documentation

## Table of Contents

- [Documentation](#documentation)
  - [Table of Contents](#table-of-contents)
  - [API](#api)
    - [Manager](#phpdockermanager)
      - [`isDockerEnvSet()`](#managerisdockerenvset)
      - [`isDockerToolbox()`](#managerisdockertoolbox)
      - [`isInstalled()`](#managerisinstalled)
    - [Machine](#phpdockercomponentmachine)
      - [`clearCommandsCache()`](#machineclearcommandscache)
      - [`find()`](#machinefind)
      - [`getActive()`](#machinegetactive)
      - [`getCommands()`](#machinegetcommands)
      - [`getEnvVars()`](#machinegetenvvars)
      - [`getIPs()`](#machinegetips)
      - [`getStatus()`](#machinegetstatus)
      - [`getURL()`](#machinegeturl)
      - [`getVersion()`](#machinegetversion)
      - [`isInstalled()`](#machineisinstalled)
      - [`kill()`](#machinekill)
      - [`remove()`](#machineremove)
      - [`restart()`](#machinerestart)
      - [`start()`](#machinestart)
      - [`stop()`](#machinestop)
      - [`upgrade()`](#machineupgrade)
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

## API

### PHPDocker\Manager

----

#### `Manager::isDockerEnvSet()`

```php
$manager->isDockerEnvSet(): bool
```

Checks if Docker environment variables are set, in particular DOCKER_HOST.

----

#### `Manager::isDockerToolbox()`

```php
$manager->isDockerToolbox(): bool
```

Returns true if Docker Toolbox is installed (by checking environment variables).

Note that in some messed up installation scenarios, this might return a false positive.

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

#### `Machine::find()`

```php
$machine->find(
    string $name
): \MachineReference
```

Returns an object representing a machine given the machine name.

Note that the machine might not exist at this or any point.

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

#### `Machine::getStatus()`

```php
$machine->getStatus(
    null|string $machineName    // name of desired machine or `null` for the default machine
): string    // Status of the requested machine (see self::STATE_* constants)
```

Returns status of default machine (if $name is null), otherwise status of the specified machine.

----

#### `Machine::getURL()`

```php
$machine->getURL(
    null|string $machineName    // name of desired machine or `null` for the default machine
): string    // URL of the requested machine
```

Returns URL of default machine (if $name is null), otherwise URL of the specified machine.

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

#### `Machine::kill()`

```php
$machine->kill(
    null|string[] $machineNames    // names of machines to kill or the default one if `null`
): $this    // current instance, for method chaining
```

Kill the specified machines.

----

#### `Machine::remove()`

```php
$machine->remove(
    string[] $machineNames     // names of machines to remove
    bool     $forcedRemoval    // If true, machine config is removed even if machine cannot be removed
): $this    // current instance, for method chaining
```

Removes the specified machine.

----

#### `Machine::restart()`

```php
$machine->restart(
    null|string[] $machineNames    // names of machines to restart or the default one if `null`
): $this    // current instance, for method chaining
```

Restarts the specified machines.

----

#### `Machine::start()`

```php
$machine->start(
    null|string[] $machineNames    // names of machines to start or the default one if `null`
): $this    // current instance, for method chaining
```

Start the specified machines.

----

#### `Machine::stop()`

```php
$machine->stop(
    null|string[] $machineNames    // names of machines to stop or the default one if `null`
): $this    // current instance, for method chaining
```

Stop the specified machines.

----

#### `Machine::upgrade()`

```php
$machine->upgrade(
    null|string[] $machineNames    // names of machines to upgrade or the default one if `null`
): $this    // current instance, for method chaining
```

Upgrade the specified machines.

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
    string $name
): \ContainerReference
```

Returns an object representing a container given the container name.

Note that the container might not exist at this or any point.

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
                                   // Important! If you want container to keep running after your code ends, this must be true.
                                   // However, if set to true you won't be able to capture execution output directly.
    array        $envVars          // a list of key=>value pairs of environments to be used inside container
    array|string $portMap          // array with string keys - a list of key-value pairs for exposing ports (key is host, value is container) eg; ['3306' => '3306']
                                   // array with integer keys - a list of port map specification strings (see docker documentation for specification) eg; ['3306:3306']
                                   // self::ALL_PORTS - exposes all exported ports (--publish-all=true) randomly
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

