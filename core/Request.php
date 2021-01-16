<?php

namespace app\core;

class Request
{
    public function getPath()
    {
        $path = $_SERVER["REQUEST_URI"] ?? "/";
        $pos = strpos($path, "?");

        if ($pos === false) {
            return $path;
        }

        $path = substr($path, 0, $pos);

        return $path;
    }

    public function getMethod()
    {
        return strtolower($_SERVER["REQUEST_METHOD"]);
    }
}
