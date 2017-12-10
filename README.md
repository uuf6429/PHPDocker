<!-- This file is generated automatically and any changes will be overwritten! -->

# PHPDocker

[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%205.6-8892BF.svg)](https://php.net/)
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](https://raw.githubusercontent.com/uuf6429/rune/master/LICENSE)
[![Docker](https://img.shields.io/badge/d-8%25-0db7ed.svg)](#supported-commands)
[![Docker Compose](https://img.shields.io/badge/c-20%25-0db7ed.svg)](#supported-commands)
[![Docker Machine](https://img.shields.io/badge/m-60%25-0db7ed.svg)](#supported-commands)

PHP library providing a simple API for [Docker cli](https://docs.docker.com/engine/reference/commandline/cli/).

## Table of Contents

- [PHPDocker](#phpdocker)
  - [Table of Contents](#table-of-contents)
  - [Why?](#why)
  - [Installation](#installation)
  - [Usage](#usage)
  - [Supported Commands](#supported-commands)
  - [Documentation](#documentation)

## Why?

Many operations in Docker are exposed via a [REST API](https://docs.docker.com/engine/api/latest/), however, some commands (eg, `docker-compose`) cannot be used from the API (because `docker-compose` itself uses the low-level API).
Additionally, if you use the REST API, you'll end up doing what the Docker cli is already doing for you.
In some cases it makes sense to use the low-level API, in which case you can use [another PHP library](https://github.com/docker-php/docker-php).

If, however, all you want is to jump in and start using Docker from your PHP application, this library fits the purpose well.

**TL:DR;**
- why not?
- supports more functionality _(eg; `docker-toolbox`)_
- fixes common issues _(eg; Docker from Docker Toolbox misses configuration and refuses to run outside of the Quickstart Terminal)_

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
<th>Docker (8%)</th><th>Docker Compose (20%)</th><th>Docker Machine (60%)</th>
    </thead><tbody>
        <tr>
            <td valign="top">
                &nbsp;&nbsp;?&nbsp;&nbsp; <a href="/DOCS.md#dockerattach" title="Docker::attach">docker attach</a><br/>
                ❌ docker build<br/>
                &nbsp;&nbsp;?&nbsp;&nbsp; <a href="/DOCS.md#dockercommit" title="Docker::commit">docker commit</a><br/>
                ❌ docker config<br/>
                ❌ docker config create<br/>
                ❌ docker config inspect<br/>
                ❌ docker config ls<br/>
                ❌ docker config rm<br/>
                ❌ docker container<br/>
                ❌ docker container attach<br/>
                ❌ docker container commit<br/>
                ❌ docker container cp<br/>
                ❌ docker container create<br/>
                ❌ docker container diff<br/>
                ❌ docker container exec<br/>
                ❌ docker container export<br/>
                ❌ docker container inspect<br/>
                ❌ docker container kill<br/>
                ❌ docker container logs<br/>
                ❌ docker container ls<br/>
                ❌ docker container pause<br/>
                ❌ docker container port<br/>
                ❌ docker container prune<br/>
                ❌ docker container rename<br/>
                ❌ docker container restart<br/>
                ❌ docker container rm<br/>
                ❌ docker container run<br/>
                ❌ docker container start<br/>
                ❌ docker container stats<br/>
                ❌ docker container stop<br/>
                ❌ docker container top<br/>
                ❌ docker container unpause<br/>
                ❌ docker container update<br/>
                ❌ docker container wait<br/>
                ✅ <a href="/DOCS.md#dockercopy" title="Docker::copy">docker cp</a><br/>
                ❌ docker create<br/>
                &nbsp;&nbsp;?&nbsp;&nbsp; <a href="/DOCS.md#dockerdiff" title="Docker::diff">docker diff</a><br/>
                ❌ docker events<br/>
                &nbsp;&nbsp;?&nbsp;&nbsp; <a href="/DOCS.md#dockerexec" title="Docker::exec">docker exec</a><br/>
                &nbsp;&nbsp;?&nbsp;&nbsp; <a href="/DOCS.md#dockerexport" title="Docker::export">docker export</a><br/>
                ❌ docker history<br/>
                ❌ docker image<br/>
                ❌ docker image build<br/>
                ❌ docker image history<br/>
                ❌ docker image import<br/>
                ❌ docker image inspect<br/>
                ❌ docker image load<br/>
                ❌ docker image ls<br/>
                ❌ docker image prune<br/>
                ❌ docker image pull<br/>
                ❌ docker image push<br/>
                ❌ docker image rm<br/>
                ❌ docker images<br/>
                ❌ docker image save<br/>
                ❌ docker image tag<br/>
                ❌ docker import<br/>
                ❌ docker info<br/>
                ❌ docker inspect<br/>
                &nbsp;&nbsp;?&nbsp;&nbsp; <a href="/DOCS.md#dockerkill" title="Docker::kill">docker kill</a><br/>
                ❌ docker load<br/>
                ❌ docker login<br/>
                ❌ docker logout<br/>
                &nbsp;&nbsp;?&nbsp;&nbsp; <a href="/DOCS.md#dockerlogs" title="Docker::logs">docker logs</a><br/>
                ❌ docker network<br/>
                ❌ docker network connect<br/>
                ❌ docker network create<br/>
                ❌ docker network disconnect<br/>
                ❌ docker network inspect<br/>
                ❌ docker network ls<br/>
                ❌ docker network prune<br/>
                ❌ docker network rm<br/>
                ❌ docker node<br/>
                ❌ docker node demote<br/>
                ❌ docker node inspect<br/>
                ❌ docker node ls<br/>
                ❌ docker node promote<br/>
                ❌ docker node ps<br/>
                ❌ docker node rm<br/>
                ❌ docker node update<br/>
                &nbsp;&nbsp;?&nbsp;&nbsp; <a href="/DOCS.md#dockerpause" title="Docker::pause">docker pause</a><br/>
                ❌ docker plugin<br/>
                ❌ docker plugin create<br/>
                ❌ docker plugin disable<br/>
                ❌ docker plugin enable<br/>
                ❌ docker plugin inspect<br/>
                ❌ docker plugin install<br/>
                ❌ docker plugin ls<br/>
                ❌ docker plugin push<br/>
                ❌ docker plugin rm<br/>
                ❌ docker plugin set<br/>
                ❌ docker plugin upgrade<br/>
                &nbsp;&nbsp;?&nbsp;&nbsp; <a href="/DOCS.md#dockerport" title="Docker::port">docker port</a><br/>
                ❌ docker ps<br/>
                ❌ docker pull<br/>
                ❌ docker push<br/>
                &nbsp;&nbsp;?&nbsp;&nbsp; <a href="/DOCS.md#dockerrename" title="Docker::rename">docker rename</a><br/>
                &nbsp;&nbsp;?&nbsp;&nbsp; <a href="/DOCS.md#dockerrestart" title="Docker::restart">docker restart</a><br/>
                &nbsp;&nbsp;?&nbsp;&nbsp; <a href="/DOCS.md#dockerremove" title="Docker::remove">docker rm</a><br/>
                ❌ docker rmi<br/>
                &nbsp;&nbsp;?&nbsp;&nbsp; <a href="/DOCS.md#dockerrun" title="Docker::run">docker run</a><br/>
                ❌ docker save<br/>
                ❌ docker search<br/>
                ❌ docker secret<br/>
                ❌ docker secret create<br/>
                ❌ docker secret inspect<br/>
                ❌ docker secret ls<br/>
                ❌ docker secret rm<br/>
                ❌ docker service<br/>
                ❌ docker service create<br/>
                ❌ docker service inspect<br/>
                ❌ docker service logs<br/>
                ❌ docker service ls<br/>
                ❌ docker service ps<br/>
                ❌ docker service rm<br/>
                ❌ docker service scale<br/>
                ❌ docker service update<br/>
                ❌ docker stack<br/>
                ❌ docker stack deploy<br/>
                ❌ docker stack ls<br/>
                ❌ docker stack ps<br/>
                ❌ docker stack rm<br/>
                ❌ docker stack services<br/>
                &nbsp;&nbsp;?&nbsp;&nbsp; <a href="/DOCS.md#dockerstart" title="Docker::start">docker start</a><br/>
                ❌ docker stats<br/>
                &nbsp;&nbsp;?&nbsp;&nbsp; <a href="/DOCS.md#dockerstop" title="Docker::stop">docker stop</a><br/>
                ❌ docker swarm<br/>
                ❌ docker swarm ca<br/>
                ❌ docker swarm init<br/>
                ❌ docker swarm join<br/>
                ❌ docker swarm join-token<br/>
                ❌ docker swarm leave<br/>
                ❌ docker swarm unlock<br/>
                ❌ docker swarm unlock-key<br/>
                ❌ docker swarm update<br/>
                ❌ docker system<br/>
                ❌ docker system df<br/>
                ❌ docker system events<br/>
                ❌ docker system info<br/>
                ❌ docker system prune<br/>
                ❌ docker tag<br/>
                &nbsp;&nbsp;?&nbsp;&nbsp; <a href="/DOCS.md#dockertop" title="Docker::top">docker top</a><br/>
                &nbsp;&nbsp;?&nbsp;&nbsp; <a href="/DOCS.md#dockerresume" title="Docker::resume">docker unpause</a><br/>
                &nbsp;&nbsp;?&nbsp;&nbsp; <a href="/DOCS.md#dockerupdate" title="Docker::update">docker update</a><br/>
                ✅ <a href="/DOCS.md#dockergetversion" title="Docker::getVersion">docker version</a><br/>
                ❌ docker volume<br/>
                ❌ docker volume create<br/>
                ❌ docker volume inspect<br/>
                ❌ docker volume ls<br/>
                ❌ docker volume prune<br/>
                ❌ docker volume rm<br/>
                &nbsp;&nbsp;?&nbsp;&nbsp; <a href="/DOCS.md#dockerwait" title="Docker::wait">docker wait</a><br/>
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
                &nbsp;✱&nbsp; docker-machine help<br/>
                ❌ docker-machine inspect<br/>
                ✅ <a href="/DOCS.md#machinegetips" title="Machine::getIPs">docker-machine ip</a><br/>
                ✅ <a href="/DOCS.md#machinekill" title="Machine::kill">docker-machine kill</a><br/>
                ❌ docker-machine ls<br/>
                ❌ docker-machine provision<br/>
                ❌ docker-machine regenerate-certs<br/>
                ✅ <a href="/DOCS.md#machinerestart" title="Machine::restart">docker-machine restart</a><br/>
                ✅ <a href="/DOCS.md#machineremove" title="Machine::remove">docker-machine rm</a><br/>
                ❌ docker-machine scp<br/>
                ❌ docker-machine ssh<br/>
                ✅ <a href="/DOCS.md#machinestart" title="Machine::start">docker-machine start</a><br/>
                ✅ <a href="/DOCS.md#machinegetstatus" title="Machine::getStatus">docker-machine status</a><br/>
                ✅ <a href="/DOCS.md#machinestop" title="Machine::stop">docker-machine stop</a><br/>
                ✅ <a href="/DOCS.md#machineupgrade" title="Machine::upgrade">docker-machine upgrade</a><br/>
                ✅ <a href="/DOCS.md#machinegeturl" title="Machine::getURL">docker-machine url</a><br/>
                ✅ <a href="/DOCS.md#machinegetversion" title="Machine::getVersion">docker-machine version</a><br/>
            </td>
        </tr>
    </tbody>
</table>

## [Documentation](/DOCS.md)

Complete up-to-date API documentation can be found [here](/DOCS.md).
