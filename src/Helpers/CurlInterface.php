<?php

namespace SimpleJwtLoginClient\Helpers;

interface CurlInterface
{
    /**
     * @param string $url
     * @param array<string,mixed> $parameters
     * @return array<string,mixed>|null
     */
    public function get($url, $parameters);

    /**
     * @param string $url
     * @param array<string,mixed> $parameters
     * @return array<string,mixed>|null
     */
    public function post($url, $parameters);

    /**
     * @param string $url
     * @param array<string,mixed> $parameters
     * @return array<string,mixed>|null
     */
    public function put($url, $parameters);

    /**
     * @param string $url
     * @param array<string,mixed> $parameters
     * @return array<string,mixed>|null
     */
    public function delete($url, $parameters);

    /**
     * @return int
     */
    public function getStatusCode();
}
