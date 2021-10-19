# Composer Parser Service

## Project Setup
```
docker build -t infraspeak-pie/composer-parser-service-composer -f .docker/composer/Dockerfile .docker/composer/
composer install
cp .env.example .env
```

## Project Run
`php artisan redis:queue`
