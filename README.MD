# Tasks API

This is a simple API for consulting daily tasks and change thier status to done/undone

I exposed an endpoint for every use case, 5 in total, they are explained down below

This API comes with a test environnement built using docker

List of commands to install/test the API is descibed down below

## Set up environnement
### Build image

```bash
docker-compose -f .docker/docker-compose.local.yml build 
```

### Start the container

```bash
docker-compose -f .docker/docker-compose.local.yml up -d 
```

### Create Tasks table
```bash
docker-compose -f .docker/docker-compose.local.yml exec web php bin/console doctrine:migrations:migrate --no-interaction
```

### Install dummy data (using fixtures)
```bash
docker-compose -f .docker/docker-compose.local.yml exec web php bin/console doctrine:fixtures:load --no-interaction 
```


### Run Unit Tests
```bash
docker-compose -f .docker/docker-compose.local.yml exec web php /var/www/html/bin/phpunit
```
> The coverage is in the folder web/coverage


## API
The API exposes 5 endpoints

3 for getting today's tasks and 2 to change the status of a Task

> GET http://localhost:8888/api/task

Get all the tasks of the day (All tasks, done and undone)

> GET http://localhost:8888/api/task/done

Get all done tasks of the day

> GET http://localhost:8888/api/task/undone

Get all undone tasks of the day

> PATCH http://localhost:8888/api/task/:taskId/done

Change the status of a task to done (May return a 404 if the task doesn't exixts)

> PATCH http://localhost:8888/api/task/:taskId/undone

Change the status of task to undone (May return a 404 if the task doesn't exixts)
