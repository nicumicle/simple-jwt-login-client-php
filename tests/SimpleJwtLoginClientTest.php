<?php
namespace SimpleJwtLoginTestClient;

use PHPUnit\Framework\MockObject\MockBuilder;
use PHPUnit\Framework\TestCase;
use SimpleJwtLoginClient\Helpers\CurlInterface;
use SimpleJwtLoginClient\SimpleJwtLoginClient;

class SimpleJwtLoginClientTest extends TestCase
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|CurlInterface
     */
    private $curlMock;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->curlMock = $this->getMockBuilder(CurlInterface::class)->getMock();
    }

    /**
     * @dataProvider buildUrlProvider
     * @param string $jwt
     * @param string|null $authCode
     * @param string|null $redirectUrl
     * @param string $expectedResult
     * @return void
     */
    public function testBuildLoginUrl($jwt, $authCode, $redirectUrl, $expectedResult)
    {
        $client = new SimpleJwtLoginClient('http://localhost');
        $client->withCurl($this->curlMock);
        $this->assertSame($expectedResult, $client->getAutologinUrl($jwt, $authCode, $redirectUrl));
    }

    /**
     * @return array<string,mixed>
     */
    public function buildUrlProvider()
    {
        return [
            'empty_strings' => [
                'jwt' => '',
                'auth_code' => '',
                'redirect_url' => '',
                'expectedResult' => 'http://localhost/?rest_route=/simple-jwt-login/v1' .
                    '/autologin&JWT=&AUTH_KEY=&redirectUrl=',
            ],
            'test_with_auth_code_null' => [
                'jwt' => '',
                'auth_code' => null,
                'redirect_url' => '',
                'expectedResult' => 'http://localhost/?rest_route=/simple-jwt-login/v1/autologin&JWT=&redirectUrl=',
            ],
            'test_with_redirect_url_null' => [
                'jwt' => '',
                'auth_code' => '',
                'redirect_url' => null,
                'expectedResult' => 'http://localhost/?rest_route=/simple-jwt-login/v1/autologin&JWT=&AUTH_KEY=',
            ],
            'test_with_null' => [
                'jwt' => '123',
                'auth_code' => null,
                'redirect_url' => null,
                'expectedResult' => 'http://localhost/?rest_route=/simple-jwt-login/v1/autologin&JWT=123',
            ],
        ];
    }

    /**
     * @return void
     */
    public function testRegisterCallsPost()
    {
        $this->curlMock->method('post')
            ->willReturn([]);
        $client = new SimpleJwtLoginClient('http://localhost');
        $client->withCurl($this->curlMock);
        $this->assertSame([], $client->registerUser('test', 'test', 'test'));
    }

    /**
     * @return void
     */
    public function testDeleteUserCallsDelete()
    {
        $this->curlMock->method('delete')
            ->willReturn([]);
        $client = new SimpleJwtLoginClient('http://localhost');
        $client->withCurl($this->curlMock);
        $this->assertSame([], $client->deleteUser('test', 'test'));
    }

    /**
     * @return void
     */
    public function testResetPasswordCallsPost()
    {
        $this->curlMock->method('post')
            ->willReturn([]);
        $client = new SimpleJwtLoginClient('http://localhost');
        $client->withCurl($this->curlMock);
        $this->assertSame([], $client->resetPassword('test', 'test'));
    }

    /**
     * @return void
     */
    public function testChangePasswordCallsPut()
    {
        $this->curlMock->method('put')
            ->willReturn([]);
        $client = new SimpleJwtLoginClient('http://localhost');
        $client->withCurl($this->curlMock);
        $this->assertSame(
            [],
            $client->changePassword('test', 'test', '123', null, 'test')
        );
        $this->assertSame(
            [],
            $client->changePassword('test', 'test', null, '123', 'test')
        );
    }

    /**
     * @return void
     */
    public function testAuthenticateCallsPost()
    {
        $this->curlMock->method('post')
            ->willReturn([]);
        $client = new SimpleJwtLoginClient('http://localhost');
        $client->withCurl($this->curlMock);
        $this->assertSame([], $client->authenticate('test', 'test', 'test'));
    }

    /**
     * @return void
     */
    public function testRefreshTokenCallsPost()
    {
        $this->curlMock->method('post')
            ->willReturn([]);
        $client = new SimpleJwtLoginClient('http://localhost');
        $client->withCurl($this->curlMock);
        $this->assertSame([], $client->refreshToken('test', 'test'));
    }

    /**
     * @return void
     */
    public function testValidateTokenCallsGet()
    {
        $this->curlMock->method('get')
            ->willReturn([]);
        $client = new SimpleJwtLoginClient('http://localhost');
        $client->withCurl($this->curlMock);
        $this->assertSame([], $client->validateToken('test', 'test'));
    }

    /**
     * @return void
     */
    public function testRevokeTokenCallsPost()
    {
        $this->curlMock->method('post')
            ->willReturn([]);
        $client = new SimpleJwtLoginClient('http://localhost');
        $client->withCurl($this->curlMock);
        $this->assertSame([], $client->revokeToken('test', 'test'));
    }
}
