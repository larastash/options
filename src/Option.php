<?php

namespace Larastash\Options;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Larastash\Options\Models\Option as Model;
use DateInterval;
use DateTimeInterface;

class Option
{
    /**
     * Set the value of the "key" option.
     *
     * @param string $key The key of the option.
     * @param mixed $value The value to set for the option.
     * @param DateInterval|DateTimeInterface|int|null $ttl The time-to-live for the option.
     * @return void
     */
    public static function set(string $key, mixed $value, DateInterval|DateTimeInterface|int|null $ttl = null): void
    {
        if ($ttl !== null) {
            Cache::put('larastash:options_' . $key, $value, $ttl);
        }

        self::query()->updateOrCreate(['key' => $key], ['value' => $value]);
    }

    /**
     * Get the value of the "key" option.
     *
     * @param string $key The key of the option.
     * @param mixed $default The default value to return if the option is not found.
     * @param DateInterval|DateTimeInterface|int|null $ttl  The time-to-live for the option (in seconds if integer).
     *                                                      If TTL is not null, then get the fresh value from the database, ignoring the cached value.
     * @return mixed The value of the option.
     */
    public static function get(string $key, mixed $default = null, DateInterval|DateTimeInterface|int|null $ttl = null): mixed
    {
        if ($ttl === null && Cache::has('larastash:options_' . $key)) {
            return Cache::get('larastash:options_' . $key);
        }

        $value = self::query()->find($key)?->value ?? $default;

        Cache::put('larastash:options_' . $key, $value, $ttl);

        return $value;
    }

    /**
     * Remove a key from the options.
     *
     * @param string $key The key of the option to remove.
     * @return void
     */
    public static function remove(string $key): void
    {
        self::query()->where('key', $key)->delete();

        Cache::forget('larastash:options_' . $key);
    }

    /**
     * Determine if the given option key exists.
     *
     * @param string $key The key of the option.
     * @return bool True if the option exists, false otherwise.
     */
    public static function exists(string $key): bool
    {
        return self::query()->where('key', $key)->exists();
    }

    /**
     * Get all option values.
     *
     * @return Collection A collection of all option values.
     */
    public static function all(): Collection
    {
        return self::query()->get();
    }

    /**
     * Get a query builder of option model.
     *
     * @return Builder A query builder instance for the option model.
     */
    public static function query(): Builder
    {
        return Model::query();
    }
}