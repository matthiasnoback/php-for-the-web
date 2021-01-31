FROM php:7.4-cli-alpine
EXPOSE 8000
WORKDIR /app
STOPSIGNAL SIGTERM
COPY php.ini $PHP_INI_DIR/conf.d/
ENTRYPOINT [ "php", "-S", "0.0.0.0:8000", "-t"]
CMD ["public/"]
