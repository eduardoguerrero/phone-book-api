
# 1. Start the container
Change to docker directory
```bash
❯ cd /path/your/project/phone-book-api/docker 
❯ docker-compose up -d
```
Run `docker ps` to find out the name of your php container. It should look like this `lillydoo_php`.
```bash
❯ docker ps
CONTAINER ID   IMAGE                   COMMAND                  CREATED        STATUS         PORTS                                                      NAMES
f034770755b0   docker_apache           "/bin/sh -c 'apachec…"   30 hours ago   Up 2 minutes   443/tcp, 9000/tcp, 0.0.0.0:8002->80/tcp, :::8002->80/tcp   lillydoo_apache
8452cd2aa618   phpmyadmin/phpmyadmin   "/docker-entrypoint.…"   30 hours ago   Up 2 minutes   0.0.0.0:8080->80/tcp, :::8080->80/tcp                      lillydoo_phpmyadmin
b5bbb40c2744   docker_php              "docker-php-entrypoi…"   30 hours ago   Up 2 minutes   9000/tcp                                                   lillydoo_php
c49b36812f21   mariadb:10.2            "docker-entrypoint.s…"   30 hours ago   Up 2 minutes   3306/tcp, 0.0.0.0:3307->3307/tcp, :::3307->3307/tcp        lillydoo_mariadb

```
Then you can enter the php container
```bash
❯ docker exec -it -u dev lillydoo_php bash
```
# In the container: Initialization
```bash
❯ composer install
❯ php bin/console doctrine:database:create
❯ php bin/console doctrine:migrations:migrate
❯ php bin/console doctrine:fixtures:load -n
❯ php bin/console cache:clear 
```

# Start symfony server

- You can start the symfony web server typing following into your local shell
```bash
❯ cd /path/your/project/phone-book-api 
❯ symfony server:start
```
If you need it, change web server listening in line 4 and line 6 in file`config/packages/nelmio_api_doc.yaml` 

You have successfully set up your coding dev environment. You can now access the api documentation in your browser.
```bash
http://127.0.0.1:8000/api/doc
```
![Alt text](img/api.png?raw=true "Api doc")

- You can access the database by typing following into your local shell

```bash
❯ docker exec -it lillydoo_mariadb bash -l
❯ mysql -uroot -proot
```

Or using phpmyadmin
```bash
http://localhost:8080/ (username: root password: root)
```

#  Execute a request

Get all contacts with curl or Postman

```bash
❯ curl --location --request GET 'http://127.0.0.1:8000/api/contacts'
```

![Alt text](img/responseApi.png?raw=true "Api response")


# Run tests

Then you can enter the php container and typing following into your local shell
```bash
./vendor/phpunit/phpunit/phpunit
```

![Alt text](img/tests.png?raw=true "Api response")


# @TODO

Add JWT authentication
