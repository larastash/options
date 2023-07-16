# Laravel Options

The `Options` class provides a convenient way to interact with option values in a Laravel application.

It allows you to set, get, remove, and check the existence of options. The class also includes methods to manage previously retrieved option values and provides a query builder for the option model.

## Requirements

- Laravel 10 (other version not tested);
- PHP ^8.1;

To support JSON fields in a database, ensure that your chosen database meets the following requirements:

- **MySQL:** Use MySQL version 5.7.8 or higher. JSON field support was introduced in MySQL starting from version 5.7.8;
- **MariaDB:** Use MariaDB version 10.2 or higher. JSON field support was introduced in MariaDB starting from version 10.2.
- **PostgreSQL:** Use PostgreSQL version 9.2 or higher. JSON field support was introduced in PostgreSQL starting from version 9.2;
- **SQLite:** Use SQLite version 3.9.0 or higher. JSON support and functions were added in SQLite starting from version 3.9.0;
- **SQL Server:** Use SQL Server 2016 or higher. JSON support was introduced in SQL Server 2016;
- **Oracle Database:** Use Oracle Database 12c Release 2 (12.2) or higher. JSON support was added in Oracle Database 12c Release 2;

## Installation

You can install it using Composer:

```shell
composer require larastash/options
```

Run database migration:

```shell
php artisan migrate
```

✨ Get to work, you're done!

## Usage

To use the `Options` class, make sure to import it into your PHP file:

```php
use Larastash\Options\Option;
```

Or get `Larastash\Options\Option` singletone class from app container:

```php
$option = app('option');
$option = app(Option::class);
```
Also, you can use the [`option()`](#helpers) helper.

### Set an Option

You can set the value of an option using the `set` method:

```php
Option::set('key', 'value');
```

This method will update the value of the option with the specified key. If the option doesn't exist, it will be created.

You can also specify a time-to-live (TTL) for the option. The TTL determines how long the option will be cached. If a TTL is specified, the option will be stored in the cache in addition to being persisted in the database:

```php
// Set an option with a TTL of 1 hour
Option::set('key', 'value', 3600);
Option::set('key', 'value', now()->addHour());
```

### Get an Option

To retrieve the value of an option, use the `get()` method:

```php
$value = Option::get('key');
```
You can also specify a default value to return if the option is not found:

```php
$value = Option::get('key', 'default');
```

If a TTL is specified and the option is found in the cache, the cached value will be returned. Otherwise, the option will be retrieved from the database.

```php
// Retrived value will be cached for 1 hour
$value = Option::get('key', 'default', 3600);
$value = Option::get('key', 'default', now()->addHour());
```

### Remove an Option

You can remove an option using the `remove` method:

```php
Option::remove('key');
```

This will delete the option from the database and remove it from the cache, if it exists.

### Check if an Option Exists

You can check if an option exists using the `exists()` method:

```php
if (Option::exists('key')) {
    // Option exists
} else {
    // Option does not exist
}
```

The `exists` method returns `true` if the option with the specified key exists in the database; otherwise, it returns `false`.

### Get All Option Values

To retrieve all option values, you can use the `all` method:

```php
$options = Option::all();
```

The `all` method returns a `Illuminate\Database\Eloquent\Collection` of all option values.

### Querying the Option Model

You can access the query builder of the option model using the `query` method:

```php
$query = Option::query();
```

The `query` method returns an instance of the `Illuminate\Database\Eloquent\Builder` class that can be used to build custom queries on the option model.

### Advanced Usage

If you need more advanced querying capabilities, you can use the `query()` method to get a query builder instance for the option model. This allows you to perform complex database queries on the option model:

```php
$query = Option::query();
$query->where('key', 'like', 'prefix%');
$options = $query->get();
```

This example retrieves all options whose keys start with a specific prefix.

## Helpers

### `option()`

The `option()` function provides a convenient way to interact with option values in a Laravel application. It acts as a wrapper around the `Options` class methods and simplifies the retrieval and setting of options.

#### Parameters:

- `$key` (string|array|null): The key of the option to retrieve or an array containing the key and value to set. If set to `null`, it will return an instance of the `Option` class.
- `$default` (mixed): (Optional) The default value to return if the option does not exist. This parameter is only used when retrieving an option value.
- `$ttl` (DateInterval|DateTimeInterface|int|null): (Optional) The default value to return if the option does not exist. This parameter is only used when retrieving an option value.

#### Return Value:

The function returns the value of the option with the specified key if a key is provided.

If an array is provided, it sets the value of the option with the specified key.

If no arguments are provided, it returns an instance of the `Option` class.

#### Usage Examples:

**Get an Option:**

```php
$value = option('key', 'default value');
$value = option('key', 'default value', ttl: 3600);
$value = option('key', 'default value', ttl: now()->addHour());
```

This retrieves the value of the option with the specified key. If the option does not exist, it returns the provided default value.

**Set an Option:**
```php
option(['key' => 'new value']);
option(['key' => 'new value'], ttl: 3600);
option(['key' => 'new value'], ttl: now()->addHour());
```
This sets the value of the option with the specified key. If the option does not exist, it will be created.

**Access the `Option` class:**
```php
$option = option();

option()->set(...);
option()->get(...);
option()->remove(...);
option()->exists(...);
option()->query(...);

// and etc...
```
This returns an instance of the `Option` class, allowing you to perform advanced operations.

## Testing

``` bash
$ composer test
```

## Contributing
If you find any issues or have suggestions for improvement, please feel free to contribute by creating a pull request or submitting an issue.

## Credits

- [chipslays](https://github.com/chipslays)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
