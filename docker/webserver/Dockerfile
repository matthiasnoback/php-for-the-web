FROM php:7.4-cli-alpine
EXPOSE 8000
WORKDIR /app
STOPSIGNAL SIGTERM
CMD [ "php", "-S", "0.0.0.0:8000", "-t", "public/" ]
