# Test task for Instapro


## Requirements
* Docker with Docker-compose

## Installation and running

* Clone the repository
* Go to the project folder
* Run `docker-compose build`
* Run `docker-compose up`
* Create a file `.env.local` and add your bitly token
  ```BITLY_TOKEN=your_token_here```
  and a percentage of using the Instapro URL shortener (default is 100)
  ```USING_INSTAPRO_URL_SHORTENER_PERCENTAGE=70```
* Open `http://localhost:8000/url/new` in browser

## Running tests

Run tests with coverage report
```
docker-compose run php bin/phpunit --coverage-html var/coverage --coverage-text
```
OR, log in a running container and run tests
```
docker exec -ti instapro_php bash
bin/phpunit --coverage-html var/coverage --coverage-text
```

You can find a coverage report in the var/coverage folder of the project