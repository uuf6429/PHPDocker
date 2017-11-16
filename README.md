# PHPDocker

[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%205.6-8892BF.svg)](https://php.net/)
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](https://raw.githubusercontent.com/uuf6429/rune/master/LICENSE)

PHP library providing a simple API for [Docker cli](https://docs.docker.com/engine/reference/commandline/cli/).

## Table of Contents

* [Machine](#machine)
    * [__construct](#__construct)
    * [getVersion](#getversion)
    * [isInstalled](#isinstalled)
    * [getCommands](#getcommands)
    * [getActive](#getactive)
    * [getIPs](#getips)
* [Manager](#manager)
    * [__construct](#__construct-1)
    * [__get](#__get)
    * [isInstalled](#isinstalled-1)
    * [isDockerToolbox](#isdockertoolbox)

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

Caution! This is method gives a rough idea of functionality as reported by
the app, however the program itself could support a different set of commands.

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

### __get

Magic getter + class PHPDoc is the only way we can implement readonly properties in PHP.

```php
Manager::__get( string $name ): null|\PHPDocker\Component\Component
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$name` | **string** |  |




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
