<!-- This file is generated automatically and any changes will be overwritten! -->

# PHPDocker

[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%205.6-8892BF.svg)](https://php.net/)
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](https://raw.githubusercontent.com/uuf6429/rune/master/LICENSE)
[![Docker](https://img.shields.io/badge/d-21%25-0db7ed.svg)](#supported-commands)
[![Docker Compose](https://img.shields.io/badge/c-20%25-0db7ed.svg)](#supported-commands)
[![Docker Machine](https://img.shields.io/badge/m-60%25-0db7ed.svg)](#supported-commands)

PHP library providing a simple API for [Docker cli](https://docs.docker.com/engine/reference/commandline/cli/).

## Table of Contents

- [PHPDocker](#phpdocker)
  - [Table of Contents](#table-of-contents)
  - [Installation](#installation)
  - [Usage](#usage)
  - [Supported Commands](#supported-commands)
  - [Documentation](/uuf6429/PHPDocker/blob/master/DOCS.md)

## Installation

First [install Composer](https://getcomposer.org/download/) and then run the following command in your project directory:

```bash
composer require uuf6429/phpdocker
```

## Usage

This library requires either [native Docker](https://www.docker.com/community-edition#download) or [Docker Toolbox](https://docs.docker.com/toolbox/overview/).

Two interfaces are provided, both of which start with the [Manager](/uuf6429/PHPDocker/blob/master/DOCS.md#phpdockermanager) class:

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
<th>Docker (21%)</th><th>Docker Compose (20%)</th><th>Docker Machine (60%)</th>
    </thead><tbody>
        <tr>
            <td valign="top">
                ❌ docker config<br/>
                ❌ docker container<br/>
                ❌ docker image<br/>
                ❌ docker network<br/>
                ❌ docker node<br/>
                ❌ docker plugin<br/>
                ❌ docker secret<br/>
                ❌ docker service<br/>
                ❌ docker stack<br/>
                ❌ docker swarm<br/>
                ❌ docker system<br/>
                ❌ docker volume<br/>
                ❌ docker config create<br/>
                ❌ docker config inspect<br/>
                ❌ docker config ls<br/>
                ❌ docker config rm<br/>
                &nbsp;&nbsp;?&nbsp;&nbsp; <a href="/uuf6429/PHPDocker/blob/master/DOCS.md#dockerattach" title="Docker::attach">docker attach</a><br/>
                ❌ docker build<br/>
                &nbsp;&nbsp;?&nbsp;&nbsp; <a href="/uuf6429/PHPDocker/blob/master/DOCS.md#dockercommit" title="Docker::commit">docker commit</a><br/>
                ✅ <a href="/uuf6429/PHPDocker/blob/master/DOCS.md#dockercopy" title="Docker::copy">docker cp</a><br/>
                ❌ docker create<br/>
                &nbsp;&nbsp;?&nbsp;&nbsp; <a href="/uuf6429/PHPDocker/blob/master/DOCS.md#dockerdiff" title="Docker::diff">docker diff</a><br/>
                ❌ docker events<br/>
                &nbsp;&nbsp;?&nbsp;&nbsp; <a href="/uuf6429/PHPDocker/blob/master/DOCS.md#dockerexec" title="Docker::exec">docker exec</a><br/>
                &nbsp;&nbsp;?&nbsp;&nbsp; <a href="/uuf6429/PHPDocker/blob/master/DOCS.md#dockerexport" title="Docker::export">docker export</a><br/>
                ❌ docker history<br/>
                ❌ docker images<br/>
                ❌ docker import<br/>
                ❌ docker info<br/>
                ❌ docker inspect<br/>
                &nbsp;&nbsp;?&nbsp;&nbsp; <a href="/uuf6429/PHPDocker/blob/master/DOCS.md#dockerkill" title="Docker::kill">docker kill</a><br/>
                ❌ docker load<br/>
                ❌ docker login<br/>
                ❌ docker logout<br/>
                &nbsp;&nbsp;?&nbsp;&nbsp; <a href="/uuf6429/PHPDocker/blob/master/DOCS.md#dockerlogs" title="Docker::logs">docker logs</a><br/>
                &nbsp;&nbsp;?&nbsp;&nbsp; <a href="/uuf6429/PHPDocker/blob/master/DOCS.md#dockerpause" title="Docker::pause">docker pause</a><br/>
                &nbsp;&nbsp;?&nbsp;&nbsp; <a href="/uuf6429/PHPDocker/blob/master/DOCS.md#dockerport" title="Docker::port">docker port</a><br/>
                ❌ docker ps<br/>
                ❌ docker pull<br/>
                ❌ docker push<br/>
                &nbsp;&nbsp;?&nbsp;&nbsp; <a href="/uuf6429/PHPDocker/blob/master/DOCS.md#dockerrename" title="Docker::rename">docker rename</a><br/>
                &nbsp;&nbsp;?&nbsp;&nbsp; <a href="/uuf6429/PHPDocker/blob/master/DOCS.md#dockerrestart" title="Docker::restart">docker restart</a><br/>
                &nbsp;&nbsp;?&nbsp;&nbsp; <a href="/uuf6429/PHPDocker/blob/master/DOCS.md#dockerremove" title="Docker::remove">docker rm</a><br/>
                ❌ docker rmi<br/>
                &nbsp;&nbsp;?&nbsp;&nbsp; <a href="/uuf6429/PHPDocker/blob/master/DOCS.md#dockerrun" title="Docker::run">docker run</a><br/>
                ❌ docker save<br/>
                ❌ docker search<br/>
                &nbsp;&nbsp;?&nbsp;&nbsp; <a href="/uuf6429/PHPDocker/blob/master/DOCS.md#dockerstart" title="Docker::start">docker start</a><br/>
                ❌ docker stats<br/>
                &nbsp;&nbsp;?&nbsp;&nbsp; <a href="/uuf6429/PHPDocker/blob/master/DOCS.md#dockerstop" title="Docker::stop">docker stop</a><br/>
                ❌ docker tag<br/>
                &nbsp;&nbsp;?&nbsp;&nbsp; <a href="/uuf6429/PHPDocker/blob/master/DOCS.md#dockertop" title="Docker::top">docker top</a><br/>
                &nbsp;&nbsp;?&nbsp;&nbsp; <a href="/uuf6429/PHPDocker/blob/master/DOCS.md#dockerresume" title="Docker::resume">docker unpause</a><br/>
                &nbsp;&nbsp;?&nbsp;&nbsp; <a href="/uuf6429/PHPDocker/blob/master/DOCS.md#dockerupdate" title="Docker::update">docker update</a><br/>
                ✅ <a href="/uuf6429/PHPDocker/blob/master/DOCS.md#dockergetversion" title="Docker::getVersion">docker version</a><br/>
                &nbsp;&nbsp;?&nbsp;&nbsp; <a href="/uuf6429/PHPDocker/blob/master/DOCS.md#dockerwait" title="Docker::wait">docker wait</a><br/>
            </td>
            <td valign="top">
                ✅ <a href="/uuf6429/PHPDocker/blob/master/DOCS.md#composebuild" title="Compose::build">compose build</a><br/>
                ❌ compose bundle<br/>
                ❌ compose config<br/>
                ❌ compose create<br/>
                ✅ <a href="/uuf6429/PHPDocker/blob/master/DOCS.md#composedown" title="Compose::down">compose down</a><br/>
                ❌ compose events<br/>
                ✅ <a href="/uuf6429/PHPDocker/blob/master/DOCS.md#composeexecute" title="Compose::execute">compose exec</a><br/>
                &nbsp;✱&nbsp; compose help<br/>
                ❌ compose images<br/>
                ❌ compose kill<br/>
                ❌ compose logs<br/>
                ❌ compose pause<br/>
                ❌ compose port<br/>
                ❌ compose ps<br/>
                ❌ compose pull<br/>
                ❌ compose push<br/>
                ❌ compose restart<br/>
                ✅ <a href="/uuf6429/PHPDocker/blob/master/DOCS.md#composeremove" title="Compose::remove">compose rm</a><br/>
                ❌ compose run<br/>
                ❌ compose scale<br/>
                ❌ compose start<br/>
                ❌ compose stop<br/>
                ❌ compose top<br/>
                ❌ compose unpause<br/>
                ❌ compose up<br/>
                ✅ <a href="/uuf6429/PHPDocker/blob/master/DOCS.md#composegetversion" title="Compose::getVersion">compose version</a><br/>
            </td>
            <td valign="top">
                ✅ <a href="/uuf6429/PHPDocker/blob/master/DOCS.md#machinegetactive" title="Machine::getActive">machine active</a><br/>
                ❌ machine config<br/>
                ❌ machine create<br/>
                ✅ <a href="/uuf6429/PHPDocker/blob/master/DOCS.md#machinegetenvvars" title="Machine::getEnvVars">machine env</a><br/>
                ❌ machine inspect<br/>
                ✅ <a href="/uuf6429/PHPDocker/blob/master/DOCS.md#machinegetips" title="Machine::getIPs">machine ip</a><br/>
                ✅ <a href="/uuf6429/PHPDocker/blob/master/DOCS.md#machinekill" title="Machine::kill">machine kill</a><br/>
                ❌ machine ls<br/>
                ❌ machine provision<br/>
                ❌ machine regenerate-certs<br/>
                ✅ <a href="/uuf6429/PHPDocker/blob/master/DOCS.md#machinerestart" title="Machine::restart">machine restart</a><br/>
                ✅ <a href="/uuf6429/PHPDocker/blob/master/DOCS.md#machineremove" title="Machine::remove">machine rm</a><br/>
                ❌ machine ssh<br/>
                ❌ machine scp<br/>
                ✅ <a href="/uuf6429/PHPDocker/blob/master/DOCS.md#machinestart" title="Machine::start">machine start</a><br/>
                ✅ <a href="/uuf6429/PHPDocker/blob/master/DOCS.md#machinegetstatus" title="Machine::getStatus">machine status</a><br/>
                ✅ <a href="/uuf6429/PHPDocker/blob/master/DOCS.md#machinestop" title="Machine::stop">machine stop</a><br/>
                ✅ <a href="/uuf6429/PHPDocker/blob/master/DOCS.md#machineupgrade" title="Machine::upgrade">machine upgrade</a><br/>
                ✅ <a href="/uuf6429/PHPDocker/blob/master/DOCS.md#machinegeturl" title="Machine::getURL">machine url</a><br/>
                ✅ <a href="/uuf6429/PHPDocker/blob/master/DOCS.md#machinegetversion" title="Machine::getVersion">machine version</a><br/>
                &nbsp;✱&nbsp; machine help<br/>
            </td>
        </tr>
    </tbody>
</table>

