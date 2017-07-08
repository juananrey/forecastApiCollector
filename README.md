forecastApiCollector
====================

Collects data from [Forecast.io](http://forecast.io) since the desired days ago,
to have more insight about the daily weather in a specific latitude/longitude.
Plus, it processes requests in a concurrent way, which is cool! Made with <3 using Symfony3 and Guzzle

Requirements
------------
 * PHP 5.4 or higher
 * [Composer](https://getcomposer.org/download/)
 * And the [usual Symfony application requirements](http://symfony.com/doc/current/reference/requirements.html)

Installation
------------

```bash
$ git clone https://github.com/juananrey/forecastApiCollector.git
$ cd forecastApiCollector/
$ composer install --no-interaction
```

In order to be able to use the [Forecast.io](http://forecast.io) API, 
you need an API key which you can get [here](https://darksky.net/dev/register).

Once you have the key, you will need to update the parameter `forecast_io_api_key` under `app/config/parameters.yml` file.


Usage
-----

There is no need to configure a virtual host in your web server to access the application.
Just use the built-in web server:

```bash
$ cd forecastApiCollector/
$ php bin/console server:start
```

This command will start a web server for the Symfony application. Now you can
access the application in your browser at <http://localhost:8000>.

By now, the API wrapper is just composed by a single endpoint:

```
GET /v1/forecast/latitude/{latitude}/longitude/{longitude}?daysAgo=xxx
```

If you don't specify the query parameter `daysAgo` , it retrieve the forecast for the last 30 days by default.

Please note two more things that you can play with in your `app/config/parameters.yml` file:

 - `forecast_io_concurrent_requests_number` : Tweaks the number of concurrent requests that the API wrapper can launch.
 - `forecast_io_allow_failed_queries` : By default, if something goes wrong in an API call we simply skip such response.
 If you want to halt in case any error happen while querying Forecast API, simply set this flag to `false`.


