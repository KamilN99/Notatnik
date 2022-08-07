<?php

declare(strict_types=1);

namespace App;

class Request
{
    private array $get = [];
    private array $post = [];
    private array $server = [];

    public function __construct(array $get, array $post, array $server)
    {
        $this->get = $get;
        $this->post = $post;
        $this->server = $server;
    }

    //pobieranie elementu z tablicy $_GET
    public function getParam(string $name, $default = null)
    {
        return $this->get[$name] ?? $default;
    }

    //pobieranie elementu z tablicy $_POST
    public function postParam(string $name, $default = null)
    {
        return $this->post[$name] ?? $default;
    }

    //czy get istnieje
    public function isGet(): bool
    {
        return $this->server['REQUEST_METHOD'] === 'GET';
    }

    //czy post istnieje
    public function isPost(): bool
    {
        return $this->server['REQUEST_METHOD'] === 'POST';
    }
}
