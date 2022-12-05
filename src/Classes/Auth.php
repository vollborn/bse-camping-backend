<?php

namespace App\Classes;

class Auth
{
    private static ?array $userData = null;

    public static function setUserData(?array $userData): void
    {
        self::$userData = $userData;
    }

    public static function getUserData(): ?array
    {
        return self::$userData;
    }
}