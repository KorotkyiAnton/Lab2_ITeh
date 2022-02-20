<?php

namespace Db;

class SingletonDbInit
{
    private static \MongoDB\Collection $db;

    private function __construct()
    {
    }

    public static function initiateDb(): void
    {
        $client = new \MongoDB\Client("mongodb://127.0.0.1/");
        static::$db = $client->library->literatures;
    }

    public static function getDb()
    {
        if (static::$db !== null) {
            return static::$db;
        }
    }
}