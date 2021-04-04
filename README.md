# Test task for Instapro


## Requirements
* Docker with Docker-compose

## Installation and running

* Clone the repository
* Go to the project folder
* Run `docker-compose build`
* Run `docker-compose up`
* Open `http://localhost:8000/url/new` in browser

## Running tests

Run tests with coverage report
```
bin/phpunit --coverage-html var/coverage --coverage-text
```