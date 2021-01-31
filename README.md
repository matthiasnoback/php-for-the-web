# Setup

If you want to run the tests for this project, but you don't want to install any specific PHP version on your computer, you can use the bundled Docker setup.
First, install Docker on your machine.
Then run:

```bash
docker-compose pull
```

This will pull the required Docker image.

Now run:

```bash
docker-compose run --rm composer install --prefer-dist --no-progress --ignore-platform-reqs
```

This will install the required PHP dependencies in `vendor/`.

Finally, run:

```bash
bin/run_tests
```

If you want to look at the website itself:

```bash
bin/start_server
```

Then go to <http://localhost:8000>

To stop the webserver:

```bash
bin/stop_server
```
