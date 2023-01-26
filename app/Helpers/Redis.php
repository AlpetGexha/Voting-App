<?php

use Illuminate\Support\Facades\Redis;

function redisRememberForever($key, Closure $callback)
{
    if (Redis::exists($key)) {
        return json_decode(Redis::get($key));
    }

    $value = $callback();

    Redis::set($key, $value);

    return json_decode($value);
}

function redisRemember($key, $callback, $ttl)
{
    if (Redis::exists($key)) {
        return json_decode(Redis::get($key));
    }

    $value = $callback();

    Redis::setex($key, $ttl, $value);

    return $value;
}

function redisGet($key, $callback = null)
{
    if (Redis::exists($key)) {
        return json_decode(Redis::get($key));
    }

    return Redis::set($key, $callback());
}

function redisSet($key, $value, $ttl = null)
{
    if ($ttl) {
        return Redis::setex($key, $ttl, $value);
    }

    return Redis::set($key, $value);
}

function redisForget($key)
{
    return Redis::del($key);
}
