# PHPDocker

[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%205.6-8892BF.svg)](https://php.net/)
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](https://raw.githubusercontent.com/uuf6429/rune/master/LICENSE)

PHP library providing a simple API for [Docker cli](https://docs.docker.com/engine/reference/commandline/cli/).

## Table of Contents

* [Compose](#compose)
    * [__construct](#__construct)
    * [getVersion](#getversion)
    * [isInstalled](#isinstalled)
    * [getCommands](#getcommands)
    * [withFile](#withfile)
    * [setComposeFile](#setcomposefile)
    * [down](#down)
    * [build](#build)
    * [remove](#remove)
* [Docker](#docker)
    * [__construct](#__construct-1)
    * [getVersion](#getversion-1)
    * [isInstalled](#isinstalled-1)
    * [getCommands](#getcommands-1)
    * [withFile](#withfile-1)
    * [setDockerFile](#setdockerfile)
    * [copy](#copy)
* [Machine](#machine)
    * [__construct](#__construct-2)
    * [getVersion](#getversion-2)
    * [isInstalled](#isinstalled-2)
    * [getCommands](#getcommands-2)
    * [getActive](#getactive)
    * [getIPs](#getips)
* [Manager](#manager)
    * [__construct](#__construct-3)
    * [isInstalled](#isinstalled-3)
    * [isDockerToolbox](#isdockertoolbox)

## Compose





* Full name: \PHPDocker\Component\Compose
* Parent class: \PHPDocker\Component\Component


### __construct



```php
Compose::__construct( null|string $binPath = null, null|\Psr\Log\LoggerInterface $logger = null )
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$binPath` | **null&#124;string** |  |
| `$logger` | **null&#124;\Psr\Log\LoggerInterface** |  |




---

### getVersion



```php
Compose::getVersion(  ): string
```







---

### isInstalled



```php
Compose::isInstalled(  ): boolean
```







---

### getCommands

Caution! This method gives a rough idea of functionality as reported by the console
app, however the program itself could support a different set of commands.

```php
Compose::getCommands( array&lt;mixed,string&gt; $parentCommands = array() ): \PHPDocker\Component\array&lt;string,
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$parentCommands` | **array<mixed,string>** | get sub-commands of this command path (mostly internal use only) |


**Return Value:**

string> the key is the command, the value is the description



---

### withFile



```php
Compose::withFile( string $configFile ): $this
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$configFile` | **string** |  |




---

### setComposeFile



```php
Compose::setComposeFile( string $composeFile ): $this
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$composeFile` | **string** |  |




---

### down



```php
Compose::down( null|string $file = null, null|string $removeImages = null, boolean $removeVolumes = false )
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$file` | **null&#124;string** |  |
| `$removeImages` | **null&#124;string** | 'local' or 'all', see `docker-compose down --help` for more info |
| `$removeVolumes` | **boolean** |  |




---

### build



```php
Compose::build( null $file = null, boolean $noCache = false, boolean $forceRemove = false, boolean $forcePull = false )
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$file` | **null** |  |
| `$noCache` | **boolean** |  |
| `$forceRemove` | **boolean** |  |
| `$forcePull` | **boolean** |  |




---

### remove



```php
Compose::remove(  $file = null,  $stopContainers = false,  $removeVolumes = false )
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$file` | **** |  |
| `$stopContainers` | **** |  |
| `$removeVolumes` | **** |  |




---

## Docker





* Full name: \PHPDocker\Component\Docker
* Parent class: \PHPDocker\Component\Component


### __construct



```php
Docker::__construct( null|string $binPath = null, null|\Psr\Log\LoggerInterface $logger = null )
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$binPath` | **null&#124;string** |  |
| `$logger` | **null&#124;\Psr\Log\LoggerInterface** |  |




---

### getVersion



```php
Docker::getVersion(  ): string
```







---

### isInstalled



```php
Docker::isInstalled(  ): boolean
```







---

### getCommands

Caution! This method gives a rough idea of functionality as reported by the console
app, however the program itself could support a different set of commands.

```php
Docker::getCommands( array&lt;mixed,string&gt; $parentCommands = array() ): \PHPDocker\Component\array&lt;string,
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$parentCommands` | **array<mixed,string>** | get sub-commands of this command path (mostly internal use only) |


**Return Value:**

string> the key is the command, the value is the description



---

### withFile



```php
Docker::withFile( string $dockerFile ): $this
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$dockerFile` | **string** |  |




---

### setDockerFile



```php
Docker::setDockerFile( string $dockerFile ): $this
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$dockerFile` | **string** |  |




---

### copy



```php
Docker::copy( string $containerName, string $sourcePath, string $targetPath ): $this
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$containerName` | **string** |  |
| `$sourcePath` | **string** |  |
| `$targetPath` | **string** |  |




---

## Machine





* Full name: \PHPDocker\Component\Machine
* Parent class: \PHPDocker\Component\Component


### __construct



```php
Machine::__construct( null|string $binPath = null, null|\Psr\Log\LoggerInterface $logger = null )
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$binPath` | **null&#124;string** |  |
| `$logger` | **null&#124;\Psr\Log\LoggerInterface** |  |




---

### getVersion



```php
Machine::getVersion(  ): string
```







---

### isInstalled



```php
Machine::isInstalled(  ): boolean
```







---

### getCommands

Caution! This method gives a rough idea of functionality as reported by the console
app, however the program itself could support a different set of commands.

```php
Machine::getCommands( array&lt;mixed,string&gt; $parentCommands = array() ): \PHPDocker\Component\array&lt;string,
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$parentCommands` | **array<mixed,string>** | get sub-commands of this command path (mostly internal use only) |


**Return Value:**

string> the key is the command, the value is the description



---

### getActive

Returns name of active machine.

```php
Machine::getActive(  $timeout = null ): string
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$timeout` | **** |  |




---

### getIPs

Returns IP of default machine (if $names is null), otherwise IPs of the specified machines.

```php
Machine::getIPs( null|array&lt;mixed,string&gt; $machineNames = null ): string|array&lt;mixed,string&gt;
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$machineNames` | **null&#124;array<mixed,string>** |  |


**Return Value:**

IP of default machine or an array of IPs for the specified machines



---

## Manager





* Full name: \PHPDocker\Manager


### __construct



```php
Manager::__construct( null|\Psr\Log\LoggerInterface $logger = null )
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$logger` | **null&#124;\Psr\Log\LoggerInterface** |  |




---

### isInstalled



```php
Manager::isInstalled(  ): boolean
```







---

### isDockerToolbox



```php
Manager::isDockerToolbox(  ): boolean
```







---



--------
> This document was automatically generated from source code comments on 2017-11-16 using [phpDocumentor](http://www.phpdoc.org/) and [cvuorinen/phpdoc-markdown-public](https://github.com/cvuorinen/phpdoc-markdown-public)
