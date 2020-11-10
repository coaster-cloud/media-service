# coaster.cloud Media Service
This is [coaster.cloud](https://coaster.cloud) media service. It generates user count statistics in several formats
for sharing. For example small banners for forum signatures or PDF files with a summary.

**This project is not meant for re-use.** It is open source to make it easy to contribute. We provide no support if you
want to run your own, and will do breaking changes without notice.

See [https://media.coaster.cloud/banner/migo315.png](https://media.coaster.cloud/banner/migo315.png) as example.

## Installation
You only need [docker-compose](https://docs.docker.com/compose/) to install this application. The app container
contains all dependencies for building and serving the application.

1. Clone this repository
2. Create and start container with `docker-compose up -d --build`
3. Install dependencies `docker-compose exec php composer install`

After that your local application will be accessible via `http://localhost:8030`.

Run `docker-compose stop` to stop and `docker-compose start` to start the application. 

## Add new banner
You can add new banners with some php code. Just create a new class and implement the `App\Banner\BannerInterface` the interface. 
Take a look at `src/Banner/TaronV1Banner.php` which creates the default banner as example.

The `create` method provide you with count statistics for the given username and the asset path if you need to load a
custom image or font your for banner creation.

```php
public function create(array $stats, string $assetPath) {}
```

Create an issue if you have any questions.

## Current implemented banners
Replace the placeholder {username} with your username at [coaster.cloud](https://coaster.cloud).

| Url | Description | Example |
|-----|-------------|---------|
| http://localhost:8030/banner/{username}.png | Create a short banner with count statistics | ![alt text](https://media.coaster.cloud/banner/migo315.png "migo315 Counts") |

For production use `https://media.coaster.cloud` instead of localhost. Example: https://media.coaster.cloud/banner/migo315.png
