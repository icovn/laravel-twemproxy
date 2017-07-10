
[![Build Status](https://travis-ci.org/icovn/laravel-twemproxy.svg?branch=master)](https://travis-ci.org/icovn/laravel-twemproxy)

## Laravel 5.2 Twemproxy

========

### Installation

Make sure you've got a memcached server php extension installed.

Add the package to your composer.json and run composer update:

```php
"icovn/laravel-twemproxy": "~1.0.0"
```

Replace "Illuminate\Cache\CacheServiceProvider::class" with "Net\Friend\Laravel\Cache\CacheServiceProvider::class" in app/config/app.php:

```php
//Illuminate\Cache\CacheServiceProvider::class,
Net\Friend\Laravel\Cache\CacheServiceProvider::class,
```

#Changes
[1.0.0] - 2017-06-20 - Release first version