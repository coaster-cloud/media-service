# coaster.cloud Media Service
This is [coaster.cloud](https://coaster.cloud) media service. It generates user count statistics in several formats
for sharing. For example small banners for forum signatures or PDF files with a summary.

**This project is not meant for re-use.** It is open source to make it easy to contribute. We provide no support if you
want to run your own, and will do breaking changes without notice.

## Installation
You only need [docker-compose](https://docs.docker.com/compose/) to install this application. The app container
contains all dependencies for building and serving the application.

1. Clone this repository
2. Create and start container with `docker-compose up -d --build`
3. Install dependencies `docker-compose exec php composer install`

After that your local application will be accessible via `http://localhost:8030`.

Run `docker-compose stop` to stop and `docker-compose start` to start the application. 

## Current implementations
Replace the placeholder {username} with your username at [coaster.cloud](https://coaster.cloud).

| Url | Description | Example |
|-----|-------------|---------|
| http://localhost:8030/banner/{username}.png | Create a short banner with count statistics | |
