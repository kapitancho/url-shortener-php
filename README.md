# URL Shortener Demo Project

## Installation
1. Install [composer](https://getcomposer.org/download/)
2. Install [docker](https://docs.docker.com/get-docker/)
3. run _composer install_
4. execute _docker compose build_
5. execute _docker-compose up -d_

Repeat 3 and 4 to update the application.

The application will be available at http://localhost:8137

## Purpose

This is just a demo project to showcase several things:
- How to make a lightweight PHP-based application using some of the Walnut libraries ([DI Container](https://github.com/kapitancho/walnut-lib-container), [Data](https://github.com/kapitancho/walnut-lib-data), [Http](https://github.com/kapitancho/walnut-lib-http), [DB](https://github.com/kapitancho/walnut-lib-db)).
- How to use _dependency injection_ especially in order to have a proper separation into different layers.
- How to implement a domain model based on interfaces (a blueprint) which is accessible through a fluent API.

## Controversial decisions
- The application is not using a framework. This is intentional. The goal is to show how to build a simple application without a framework.
- Instead of using the typical chain - Controller, Service, Repository there we have a different approach. The application is using a domain model which is accessible through a fluent API. This way the Controller entry points use an intuitive API to interact with the domain model.
- Some interfaces and their implementations use the same class names but in different namespaces. This might be confusing in some aspects but ideally the developers should only know about the interface and not about the implementation.

## Out of scope
- While the Walnut libraries contains a few other capabilities like an _ORM_ or a _Template Engine_ they are not used in this project.

## Implementations in other languages
For comparison purposes, the same application will also be implemented in other languages - 
- Go 
- Walnut-Lang

Once the implementations are ready, they will be available linked here.