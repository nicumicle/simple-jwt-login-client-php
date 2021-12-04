<?php

namespace SimpleJwtLoginClient;

use SimpleJwtLoginClient\Helpers\Curl;
use SimpleJwtLoginClient\Helpers\CurlInterface;
use SimpleJwtLoginClient\Helpers\Domain;

class SimpleJwtLoginClient
{

    /**
     * @var Domain
     */
    private $domain;

    /**
     * @var CurlInterface
     */
    private $curl;

    /**
     * @param string $domain
     * @param string $namespace
     */
    public function __construct($domain, $namespace = '/simple-jwt-login/v1')
    {
        $this->domain = new Domain($domain, $namespace);
        $this->curl = new Curl();
    }

    /**
     * @param CurlInterface $curl
     * @return $this
     */
    public function withCurl($curl)
    {
        $this->curl = $curl;

        return $this;
    }

    /**
     * @param string $jwt
     * @param null|string $authCode
     * @param null|string $redirectUrl
     * @return string
     */
    public function getAutologinUrl($jwt, $authCode = null, $redirectUrl = null)
    {
        $url = $this->domain->buildUrl() . '/autologin'
            . '&JWT=' . $jwt;
        if (is_string($authCode)) {
            $url .= '&AUTH_KEY=' . $authCode;
        }
        if (is_string($redirectUrl)) {
            $url .= '&redirectUrl=' . urlencode($redirectUrl);
        }

        return $url;
    }

    /**
     * @param string $email
     * @param string $password
     * @param null|string $authCode
     * @return array<string,mixed>|null
     */
    public function registerUser($email, $password, $authCode = null)
    {
        $params = [
            'email' => $email,
            'password' => $password,
        ];

        if (is_string($authCode)) {
            $params['AUTH_KEY'] = $authCode;
        }
        return $this->curl->post(
            $this->domain->buildUrl() . '/users',
            [
                'body' => $params,
                'headers' => [
                    'Content-type: application/json',
                ]
            ]
        );
    }

    /**
     * @param string $jwt
     * @param null|string $authCode
     * @return array<string,mixed>|null
     */
    public function deleteUser($jwt, $authCode = null)
    {
        $params = [
            'JWT' => $jwt,
        ];
        if (is_string($authCode)) {
            $params['AUTH_KEY'] = $authCode;
        }
        return $this->curl->delete(
            $this->domain->buildUrl() . '/users',
            [
                'body' => $params,
                'headers' => [
                    'Content-type: application/json',
                ]
            ]
        );
    }

    /**
     * @param string $email
     * @param null|string $authCode
     * @return array<string,mixed>|null
     */
    public function resetPassword($email, $authCode = null)
    {
        $params = [
            'email' => $email,
        ];

        if (is_string($authCode)) {
            $params['AUTH_KEY'] = $authCode;
        }

        return $this->curl->post(
            $this->domain->buildUrl() . '/user/reset_password',
            [
                'body' => $params,
                'headers' => [
                    'Content-type: application/json',
                ]
            ]
        );
    }

    /**
     * @param string $email
     * @param string $newPassword
     * @param null|string $code
     * @param null|string $jwt
     * @param null|string $authCode
     * @return array<string,mixed>|null
     */
    public function changePassword($email, $newPassword, $code = null, $jwt = null, $authCode = null)
    {
        $params = [
            'email' => $email,
            'new_password' => $newPassword
        ];
        if (is_string($authCode)) {
            $params['AUTH_KEY'] = $authCode;
        }
        if (is_string($jwt)) {
            $params['JWT'] = $jwt;
        } elseif (is_string($code)) {
            $params['code'] = $code;
        }

        return $this->curl->put(
            $this->domain->buildUrl() . '/user/reset_password',
            [
                'body' => $params,
                'headers' => [
                    'Content-type: application/json',
                ]
            ]
        );
    }


    /**
     * @param string $email
     * @param string $password
     * @param null|string $authCode
     * @return array<string,mixed>|null
     */
    public function authenticate($email, $password, $authCode = null)
    {
        $params = [
            'email' => $email,
            'password' => $password
        ];
        if (is_string($authCode)) {
            $params['AUTH_KEY'] = $authCode;
        }

        return $this->curl->post(
            $this->domain->buildUrl() . '/auth',
            [
                'body' => $params,
                'headers' => [
                    'Content-type: application/json',
                ]
            ]
        );
    }

    /**
     * @param string $jwt
     * @param null|string $authCode
     * @return array<string,mixed>|null
     */
    public function refreshToken($jwt, $authCode = null)
    {
        $params = [
            'JWT' => $jwt,
        ];
        if (is_string($authCode)) {
            $params['AUTH_KEY'] = $authCode;
        }

        return $this->curl->post(
            $this->domain->buildUrl() . '/auth/refresh',
            [
                'body' => $params,
                'headers' => [
                    'Content-type: application/json',
                ]
            ]
        );
    }

    /**
     * @param string $jwt
     * @param null|string $authCode
     * @return array<string,mixed>|null
     */
    public function validateToken($jwt, $authCode = null)
    {
        $params = [
            'JWT' => $jwt,
        ];
        if (is_string($authCode)) {
            $params['AUTH_KEY'] = $authCode;
        }

        return $this->curl->get(
            $this->domain->buildUrl() . '/auth/validate',
            [
                'body' => $params,
                'headers' => [
                    'Content-type: application/json',
                ]
            ]
        );
    }

    /**
     * @param string $jwt
     * @param null|string $authCode
     * @return array<string,mixed>|null
     */
    public function revokeToken($jwt, $authCode = null)
    {
        $params = [
            'JWT' => $jwt,
        ];
        if (is_string($authCode)) {
            $params['AUTH_KEY'] = $authCode;
        }

        return $this->curl->post(
            $this->domain->buildUrl() . '/auth/revoke',
            [
                'body' => $params,
                'headers' => [
                    'Content-type: application/json',
                ]
            ]
        );
    }
}
