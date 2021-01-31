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

```
bin/run_tests
```
