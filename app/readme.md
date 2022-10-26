Product Project
=================

Product CRUD in Nette Framework  -  [nette.org](nette.org)  
Using Docker, Nette Framework 3.1, PHP 8.1, Nginx, Adminer, MariaDB 10.8, Bootstrap 5, FeathersJS


Requirements
------------

- requires Docker


Installation
------------

1. Clone this repo with GIT.
2. Install docker in you don't have it (https://www.docker.com/products/docker-desktop)
3. Get into folder `docker` and run `docker-compose up`. First run can take about 10 mins depending on your machine performance (the program will make libraries installation for the first time).
4. Visit http://localhost:8080 in your browser.


First-run
----------------

1. Get inside be container `docker exec -it product bash`
2. Run `composer install`
3. Import database (adminer, phpmyadmin, ...) from `app/product.sql`



Testing
----------------

PHPStan - `composer phpstan`  
ECS(easy-coding-standard) - `composer ecs` - dry run  
ECS(easy-coding-standard) - `composer ecs-fix` - fix  

Run test `composer test` requires test database.  
Import database from `app/product_test.sql`


Adminer
----------------

Visit http://localhost:9009  
Server: mysql  
User / pasword: root / root  

Fronend and Backend
----------------
Fronend: http://localhost:8080
Backend: http://localhost:8080/admin
