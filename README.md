# Composer Parser Service

## PIE Intro
This is a service that belongs to a bigger project (PIE). PIE's objective is to return all issues from repositories present on a `composer.json` or a `package.json` file.
The idea came in Hactoberfest 2020, when the team wanted to contribute to the packages we are using, but there was no easy way to list them all.
PIE project is composed by 5 projects:
* [pie-api](https://github.com/Infraspeak/pie-api) - The api service
* [pie-frontend](https://github.com/Infraspeak/pie-frontend) - The frontend service written in Vue.js
* [pie-composer-parser-service](https://github.com/Infraspeak/pie-composer-parser-service) - The service responsible for parsing `composer.json` files, this project
* [pie-npm-parser-service](https://github.com/Infraspeak/pie-npm-parser-service) - The service responsible for parsing `package.json` files
* [pie-github-issue-finder-service](https://github.com/Infraspeak/pie-github-issue-finder-service) - The service responsible for finding package issues on Github

## Resume
This service is connected to a Redis channel, listening for messages that contain the content of `composer.json` files. It will then parse those contents and inject into a different Redis channel all repositories found.

## Project Setup
The following commands assume you have `.direnv` installed and authorized. Check how to do it [here](https://direnv.net/docs/installation.html)
```
docker build -t infraspeak-pie/composer-parser-service-composer -f .docker/composer/Dockerfile .docker/composer/
composer install
cp .env.example .env
```

## Project Run
`PHP artisan redis:queue`

## How it works
This service is connected to a Redis channel listening for messages with a specific topic (defaults to `COMPOSER_FILE`). Those messages contain a UUID and the content of a `composer.json` file ex:
```json
{
   "headers": {
      // uuid identifier
   },
   "payload": {
      // composer.json file content
   }
}
```
Upon receiving a message, the service will list all repositories present on the `composer.json` file and broadcast a message into another channel with the repository information. This new channel depends on the package hosting location and will have the form of `REPO_<DOMAIN>` ex: `REPO_GITHUB.COM`, `REPO_GITLAB.COM`.

```json
{
   "headers": {
      // uuid identifier
   },
   "payload": {
      "name": , //package name
      "version": , // package version
      "url": // package url
   }
}
```
