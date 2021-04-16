<?php


namespace JsonUtil;

class JsonUtil
{
    public static function extract(string $file):array
    {
        return json_decode(file_get_contents($file), true);
    }

    public static function insert(array $payload, string $file):bool
    {
        return file_put_contents($file, json_encode($payload));
    }
}
//composer dump-autoload after creating this file.