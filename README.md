# coaster.cloud Media Service
This is [coaster.cloud](https://coaster.cloud) media service. It generates user count statistics in several formats
for sharing. For example small banners for forum signatures or PDF files with a summary.

**This project is not meant for re-use.** It is open source to make it easy to contribute. We provide no support if you
want to run your own, and will do breaking changes without notice.

See [https://media.coaster.cloud/banner/migo315/taron_v1.png](https://media.coaster.cloud/banner/migo315/taron_v1.png) as example.

## Installation
You only need [docker-compose](https://docs.docker.com/compose/) to install this application. The app container
contains all dependencies for building and serving the application. The installation can take a few minutes.

1. Clone this repository
2. Create and start container with `docker-compose up -d --build`
3. Install dependencies `docker-compose exec php composer install`

After that your local application will be accessible via `http://localhost`.

Run `docker-compose stop` to stop and `docker-compose start` to start the application. 

## Add new banner
We would like to see some new banners. You only need some PHP code. 
Just create a new class and implement the `App\Banner\BannerInterface` the interface. 
Take a look at `src/Banner/TaronV1Banner.php` which creates the default banner as example.

The `create` method provide you with count statistics for the given username and the asset path if you need to load a
custom image or font your for banner creation.

Create an issue if you have any questions.

## Current banners
There are different banner variants implemented. Just replace `{username}` with your username at 
[coaster.cloud](https://coaster.cloud) and `{variant}` with your desired variant.

Local: `http://localhost/banner/{username}/{variant}.png`

Production: `https://media.coaster.cloud/banner/{username}/{variant}.png`

Example: `https://media.coaster.cloud/banner/migo315/taron_v1.png`

| Variant    | Example |
|------------|---------|
| `taron_v1` | ![alt text](https://media.coaster.cloud/banner/migo315/taron_v1.png "migo315 Counts") |
