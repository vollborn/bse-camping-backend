<?php

namespace App\Classes;

class Body
{
    public static function get(): array
    {
        $body = array_merge($_GET, $_POST, $_FILES);

        if (
            isset($_SERVER['CONTENT_TYPE'])
            && $_SERVER['CONTENT_TYPE'] === 'application/json'
        ) {
            $json = file_get_contents('php://input');
            $parsed = json_decode($json, true);

            if ($parsed) {
                $body = array_merge($body, $parsed);
            }
        }

        return $body;
    }
}
