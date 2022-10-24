<?php

namespace MfaFast\Http;

use MfaFast\Support\Arr;
use MfaFast\Support\Str;

class Request
{
    /**
     * @return mixed|string path of request
     */
    public function path()
    {
        $path = $_SERVER['REQUEST_URI'];
        //if query parameters founded remove it from path
        return str_contains($path, '?') ? explode('?', $path)[0] : $path;
    }

    /**
     * @return array|false|string|string[]|null method of request
     */
    public function method()
    {
        return Str::lower($_SERVER['REQUEST_METHOD']);
    }

    /**
     * @return array of query parameters sent in(get method) & post form data in(post method)
     */
    public function all()
    {
        return $_REQUEST;
    }

    /**
     * @param $keys
     * @return array of only key
     */
    public function only($keys)
    {
        return Arr::only($this->all(), $keys);
    }

    /**
     * @param $key
     * @return mixed|null of specific key value
     */
    public function get($key)
    {
        return Arr::get($this->all(), $key);
    }
}
