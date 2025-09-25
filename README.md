# Docker TP3 Infrastructure

This repository contains a multi-step Docker project to deploy a simple PHP web application with NGINX and MariaDB.

## Project Structure

```
docker-tp3-infra/
│── step1/       # NGINX + PHP-FPM
│── step2/       # Adds MariaDB and test.php CRUD
│── step3/       # Full Docker Compose orchestration
```

## Step 1 – NGINX + PHP-FPM

1. `index.php` displays PHP information.
2. Run manually using Docker:

```bash
docker network create tp3-net
docker run -d --name script --network tp3-net -v $(pwd)/step1/app:/app php:8.2-fpm
docker run -d --name http --network tp3-net -p 8080:8080 -v $(pwd)/step1/app:/app -v $(pwd)/step1/nginx/default.conf:/etc/nginx/conf.d/default.conf nginx:alpine
```

* Access [http://localhost:8080/index.php](http://localhost:8080/index.php)

## Step 2 – Add MariaDB + test.php

1. Adds a MariaDB container and `test.php` to perform CRUD operations.
2. Requires a known root password (e.g., `mysecretpassword`) for PHP to connect.
3. Sample commands:

```bash
docker run -d --name data --network tp3-net -e MARIADB_ROOT_PASSWORD=mysecretpassword -v $(pwd)/step2/db:/docker-entrypoint-initdb.d mariadb:latest
docker build -t my-php-fpm step2/php
docker run -d --name script --network tp3-net -v $(pwd)/step2/app:/app my-php-fpm
docker run -d --name http --network tp3-net -p 8080:8080 -v $(pwd)/step2/app:/app -v $(pwd)/step1/nginx/default.conf:/etc/nginx/conf.d/default.conf nginx:alpine
```

* Access [http://localhost:8080/test.php](http://localhost:8080/test.php) to see database operations.

## Step 3 – Docker Compose

1. Fully orchestrates HTTP, PHP-FPM, and MariaDB with a single command.
2. `docker-compose.yml` is located in `step3/`.

```bash
cd step3
docker-compose up -d --build
```

* Access:

  * [http://localhost:8080/index.php](http://localhost:8080/index.php)
  * [http://localhost:8080/test.php](http://localhost:8080/test.php)

## Notes

* All containers are connected through the `tp3-net` Docker network.
* PHP files are mounted as volumes for live updates.
* MariaDB initialization only runs on the first container startup.
