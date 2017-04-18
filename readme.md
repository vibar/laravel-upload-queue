## Laravel queue and websocket notification test

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
- Repositories
- Custom exceptions
- Broadcast private channel
- Decouple parse file logic (bind abstract Parse / SpreadsheetParser)
- 2 jobs? extract and import 