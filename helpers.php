<?php

use Larastash\Options\Option;

if (! function_exists('option')) {
    /**
     * @param string|array|null                         $key     The key of the option to retrieve or an array containing the key and value to set.
     * @param mixed                                     $default (Optional) The default value to return if the option does not exist (only used when retrieving).
     * @param DateInterval|DateTimeInterface|int|null   $ttl     (Optional) The time-to-live for the option (in seconds if integer).
     * @return Option|mixed                             - If a key is provided, the function returns the value of the option with the specified key.
     *                                                  - If an array is provided, the function sets the value of the option with the specified key.
     *                                                  - If no arguments are provided, the function returns an instance of the `Option` class.
     */
    function option(string|array|null $key = null, mixed $default = null, DateInterval|DateTimeInterface|int|null $ttl = null): mixed
    {
        /** @var Option */
        $option = app(Option::class);

        if (is_string($key)) {
            return $option->get($key, $default, $ttl);
        }

        if (is_array($key)) {
            if (array_is_list($key)) {
                $option->set($key[0], $key[1], $ttl);
            } else {
                $option->set(key($key), current($key), $ttl);
            }
        }

        return $option;
    }
}