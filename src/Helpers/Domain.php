<?php

namespace SimpleJwtLoginClient\Helpers;

class Domain
{
    /**
     * @var string
     */
    private $domain;
    /**
     * @var string
     */
    private $namespace;

    /**
     * @param string $domain
     * @param string $namespace
     */
    public function __construct($domain, $namespace)
    {
        $this->domain = $domain;
        $this->namespace = $namespace;
    }

    /**
     * @return string
     */
    public function buildUrl()
    {
        return rtrim($this->domain, '/') . '/?rest_route=/' . trim($this->namespace, '/');
    }
}
