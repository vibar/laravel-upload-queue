# Laravel test with upload, queue and broacasting event

### Installation

```
composer install
```

```
php artisan key:generate
```

Create a `.env` file config.

- Set database options
- Set queue options (tested with database)
- Set broadcast options (tested with pusher)

Run migrations

```
php artisan migrate
```

### See in action

```
php artisan serve
```

### Tests

```
php vendor/bin/phpunit
```

### TODO

- Improve tests 
- Custom exceptions
- Configs
- Broadcast private channel