# Clear OPcache with ease

This Laravel package allows you to clear OPcache, solving a common problem related to cache invalidation during atomic
deployments (also called "zero downtime deploy").

## Getting Started

These instructions allow you to install the package into an existing Laravel app.

### Installation

You can install this package via Composer using:

```bash
composer require steve-moretz/laravel-opcache
```

### Config Website Url

```bash
php artisan vendor:publish --provider="SteveMoretz\LaravelOpcacheClear\OpcacheClearServiceProvider"
```

Now you can go ahead and change the website url if necessary.

### Usage

### Clear

```bash
php artisan opcache:clear
```

### Watch Invalidate Cache

First you need to install

```bash
yarn add chokidar
```

then you can run

```bash
php artisan opcache:watch
```

### Suggestion

Run this command during deployment process in order to automate the cleaning process before you app became active!
