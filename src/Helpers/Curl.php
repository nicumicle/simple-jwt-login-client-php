<?php

namespace SimpleJwtLoginClient\Helpers;

class Curl implements CurlInterface
{
    const REQUEST_METHOD_GET = 'GET';
    const REQUEST_METHOD_POST = 'POST';
    const REQUEST_METHOD_PUT = 'PUT';
    const REQUEST_METHOD_DELETE = 'DELETE';

    /**
     * @var integer
     */
    private $statusCode;


    /**
     * @param string $method
     * @param string $url
     * @param array<string,mixed> $parameters
     * @return mixed[]|null
     */
    private function call($method, $url, $parameters)
    {
        $args = array(
            'method' => strtoupper($method),
            'timeout' => isset($parameters['timeout'])
                ? $parameters['timeout']
                : 10,
            'redirection' => isset($parameters['redirection'])
                ? $parameters['redirection']
                : 10,
        );

        $args['body'] = [];
        if (isset($parameters['body'])) {
            $args['body'] = $parameters['body'];
        }
        if (isset($parameters['headers'])) {
            $args['headers'] = $parameters['headers'];
        }

        $curl = curl_init($url);
        if (!$curl) {
            return null;
        }

        curl_setopt_array($curl, [
            CURLOPT_CUSTOMREQUEST => strtoupper($method),
            CURLOPT_CONNECTTIMEOUT => $args['timeout'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HEADER => [],
            CURLOPT_POSTFIELDS => $args['body']
        ]);

        $response = curl_exec($curl);
        /** @var int $statusCode */
        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $this->statusCode = $statusCode;
        curl_close($curl);

        if (is_bool($response)) {
            return null;
        }
        /** @var array<string,mixed>|null $result */
        $result = json_decode($response, true);

        return $result;
    }

    public function get($url, $parameters)
    {
        return $this->call(self::REQUEST_METHOD_GET, $url, $parameters);
    }

    public function post($url, $parameters)
    {
        return $this->call(self::REQUEST_METHOD_POST, $url, $parameters);
    }

    public function put($url, $parameters)
    {
        return $this->call(self::REQUEST_METHOD_PUT, $url, $parameters);
    }

    public function delete($url, $parameters)
    {
        return $this->call(self::REQUEST_METHOD_DELETE, $url, $parameters);
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }
}
