<?php

namespace App\Classes;

use function file_get_contents;

class Response
{
    private mixed $content;
    private int $status;

    public function __construct($content = [], int $status = 200)
    {
        $this->content = $content;
        $this->status = $status;
    }

    public static function create($content = [], int $status = 200): static
    {
        return new self($content, $status);
    }

    public static function view(string $view, int $status = 200): static
    {
        $content = file_get_contents('views/' . $view);

        return new self($content, $status);
    }

    public function __toString(): string
    {
        http_response_code($this->status);

        if (gettype($this->content) === "array") {
            header('Content-Type: application/json; charset=utf-8');
            return json_encode($this->content);
        }

        return (string)$this->content;
    }
}