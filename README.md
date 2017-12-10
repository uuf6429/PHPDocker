<!-- This file is generated automatically and any changes will be overwritten! -->

# PHPDocker

[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%205.6-8892BF.svg)](https://php.net/)
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](https://raw.githubusercontent.com/uuf6429/rune/master/LICENSE)
[![Docker](https://img.shields.io/badge/d-15%25-0db7ed.svg)](#supported-commands)
[![Docker Compose](https://img.shields.io/badge/c-20%25-0db7ed.svg)](#supported-commands)
[![Docker Machine](https://img.shields.io/badge/m-60%25-0db7ed.svg)](#supported-commands)

PHP library providing a simple API for [Docker cli](https://docs.docker.com/engine/reference/commandline/cli/).

## Table of Contents

- [PHPDocker](#phpdocker)
  - [Table of Contents](#table-of-contents)
  - [Installation](#installation)
  - [Usage](#usage)
  - [Supported Commands](#supported-commands)
  - [Documentation](#documentation)

## Installation

First [install Composer](https://getcomposer.org/download/) and then run the following command in your project directory:

```bash
composer require uuf6429/phpdocker
```

## Usage

This library requires either [native Docker](https://www.docker.com/community-edition#download) or [Docker Toolbox](https://docs.docker.com/toolbox/overview/).

Two interfaces are provided, both of which start with the [Manager](/DOCS.md#phpdockermanager) class:

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

- ✅ _Fully implemented._
- &nbsp;&nbsp;?&nbsp;&nbsp; _Incomplete (check method for details)._
- ❌ _Not implemented yet._
- &nbsp;✱&nbsp; _Not (and won't be) implemented._

<table>
    <thead>
<th>Docker (15%)</th><th>Docker Compose (20%)</th><th>Docker Machine (60%)</th>
    </thead><tbody>
        <tr>
            <td valign="top">
                ❌ 1 config<br/>
                ❌ 1 container<br/>
                ❌ 1 image<br/>
                ❌ 1 network<br/>
                ❌ 1 node<br/>
                ❌ 1 plugin<br/>
                ❌ 1 secret<br/>
                ❌ 1 service<br/>
                ❌ 1 stack<br/>
                ❌ 1 swarm<br/>
                ❌ 1 system<br/>
                ❌ 1 volume<br/>
                ❌ 1 config create<br/>
                ❌ 1 config inspect<br/>
                ❌ 1 config ls<br/>
                ❌ 1 config rm<br/>
                &nbsp;&nbsp;?&nbsp;&nbsp; <a href="/DOCS.md#dockerattach" title="Docker::attach">1 attach</a><br/>
                ❌ 1 build<br/>
                &nbsp;&nbsp;?&nbsp;&nbsp; <a href="/DOCS.md#dockercommit" title="Docker::commit">1 commit</a><br/>
                ❌ 1 cp<br/>
                ❌ 1 create<br/>
                &nbsp;&nbsp;?&nbsp;&nbsp; <a href="/DOCS.md#dockerdiff" title="Docker::diff">1 diff</a><br/>
                ❌ 1 events<br/>
                &nbsp;&nbsp;?&nbsp;&nbsp; <a href="/DOCS.md#dockerexec" title="Docker::exec">1 exec</a><br/>
                &nbsp;&nbsp;?&nbsp;&nbsp; <a href="/DOCS.md#dockerexport" title="Docker::export">1 export</a><br/>
                ❌ 1 history<br/>
                ❌ 1 images<br/>
                ❌ 1 import<br/>
                ❌ 1 info<br/>
                ❌ 1 inspect<br/>
                &nbsp;&nbsp;?&nbsp;&nbsp; <a href="/DOCS.md#dockerkill" title="Docker::kill">1 kill</a><br/>
                ❌ 1 load<br/>
                ❌ 1 login<br/>
                ❌ 1 logout<br/>
                &nbsp;&nbsp;?&nbsp;&nbsp; <a href="/DOCS.md#dockerlogs" title="Docker::logs">1 logs</a><br/>
                &nbsp;&nbsp;?&nbsp;&nbsp; <a href="/DOCS.md#dockerpause" title="Docker::pause">1 pause</a><br/>
                &nbsp;&nbsp;?&nbsp;&nbsp; <a href="/DOCS.md#dockerport" title="Docker::port">1 port</a><br/>
                ❌ 1 ps<br/>
                ❌ 1 pull<br/>
                ❌ 1 push<br/>
                &nbsp;&nbsp;?&nbsp;&nbsp; <a href="/DOCS.md#dockerrename" title="Docker::rename">1 rename</a><br/>
                &nbsp;&nbsp;?&nbsp;&nbsp; <a href="/DOCS.md#dockerrestart" title="Docker::restart">1 restart</a><br/>
                ❌ 1 rm<br/>
                ❌ 1 rmi<br/>
                &nbsp;&nbsp;?&nbsp;&nbsp; <a href="/DOCS.md#dockerrun" title="Docker::run">1 run</a><br/>
                ❌ 1 save<br/>
                ❌ 1 search<br/>
                &nbsp;&nbsp;?&nbsp;&nbsp; <a href="/DOCS.md#dockerstart" title="Docker::start">1 start</a><br/>
                ❌ 1 stats<br/>
                &nbsp;&nbsp;?&nbsp;&nbsp; <a href="/DOCS.md#dockerstop" title="Docker::stop">1 stop</a><br/>
                ❌ 1 tag<br/>
                &nbsp;&nbsp;?&nbsp;&nbsp; <a href="/DOCS.md#dockertop" title="Docker::top">1 top</a><br/>
                ❌ 1 unpause<br/>
                &nbsp;&nbsp;?&nbsp;&nbsp; <a href="/DOCS.md#dockerupdate" title="Docker::update">1 update</a><br/>
                ❌ 1 version<br/>
                &nbsp;&nbsp;?&nbsp;&nbsp; <a href="/DOCS.md#dockerwait" title="Docker::wait">1 wait</a><br/>
            </td>
            <td valign="top">
                ✅ <a href="/DOCS.md#composebuild" title="Compose::build">docker-compose build</a><br/>
                ❌ docker-compose bundle<br/>
                ❌ docker-compose config<br/>
                ❌ docker-compose create<br/>
                ✅ <a href="/DOCS.md#composedown" title="Compose::down">docker-compose down</a><br/>
                ❌ docker-compose events<br/>
                ✅ <a href="/DOCS.md#composeexecute" title="Compose::execute">docker-compose exec</a><br/>
                &nbsp;✱&nbsp; docker-compose help<br/>
                ❌ docker-compose images<br/>
                ❌ docker-compose kill<br/>
                ❌ docker-compose logs<br/>
                ❌ docker-compose pause<br/>
                ❌ docker-compose port<br/>
                ❌ docker-compose ps<br/>
                ❌ docker-compose pull<br/>
                ❌ docker-compose push<br/>
                ❌ docker-compose restart<br/>
                ✅ <a href="/DOCS.md#composeremove" title="Compose::remove">docker-compose rm</a><br/>
                ❌ docker-compose run<br/>
                ❌ docker-compose scale<br/>
                ❌ docker-compose start<br/>
                ❌ docker-compose stop<br/>
                ❌ docker-compose top<br/>
                ❌ docker-compose unpause<br/>
                ❌ docker-compose up<br/>
                ✅ <a href="/DOCS.md#composegetversion" title="Compose::getVersion">docker-compose version</a><br/>
            </td>
            <td valign="top">
                ✅ <a href="/DOCS.md#machinegetactive" title="Machine::getActive">docker-machine active</a><br/>
                ❌ docker-machine config<br/>
                ❌ docker-machine create<br/>
                ✅ <a href="/DOCS.md#machinegetenvvars" title="Machine::getEnvVars">docker-machine env</a><br/>
                ❌ docker-machine inspect<br/>
                ✅ <a href="/DOCS.md#machinegetips" title="Machine::getIPs">docker-machine ip</a><br/>
                ✅ <a href="/DOCS.md#machinekill" title="Machine::kill">docker-machine kill</a><br/>
                ❌ docker-machine ls<br/>
                ❌ docker-machine provision<br/>
                ❌ docker-machine regenerate-certs<br/>
                ✅ <a href="/DOCS.md#machinerestart" title="Machine::restart">docker-machine restart</a><br/>
                ✅ <a href="/DOCS.md#machineremove" title="Machine::remove">docker-machine rm</a><br/>
                ❌ docker-machine ssh<br/>
                ❌ docker-machine scp<br/>
                ✅ <a href="/DOCS.md#machinestart" title="Machine::start">docker-machine start</a><br/>
                ✅ <a href="/DOCS.md#machinegetstatus" title="Machine::getStatus">docker-machine status</a><br/>
                ✅ <a href="/DOCS.md#machinestop" title="Machine::stop">docker-machine stop</a><br/>
                ✅ <a href="/DOCS.md#machineupgrade" title="Machine::upgrade">docker-machine upgrade</a><br/>
                ✅ <a href="/DOCS.md#machinegeturl" title="Machine::getURL">docker-machine url</a><br/>
                ✅ <a href="/DOCS.md#machinegetversion" title="Machine::getVersion">docker-machine version</a><br/>
                &nbsp;✱&nbsp; docker-machine help<br/>
            </td>
        </tr>
    </tbody>
</table>

## [Documentation](/DOCS.md)

Complete up-to-date API documentation can be found [here](/DOCS.md).
