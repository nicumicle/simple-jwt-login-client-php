<?php

namespace SimpleJwtLoginTestClient\Helpers;

use PHPUnit\Framework\TestCase;
use SimpleJwtLoginClient\Helpers\Domain;

class DomainTest extends TestCase
{
    /**
     * @dataProvider domainProvider
     * @param string $domainName
     * @param string $namespace
     * @param string $expectedResult
     * @return void
     */
    public function testBuildUrl($domainName, $namespace, $expectedResult)
    {
        $domain = new Domain($domainName, $namespace);
        $this->assertSame(
            $expectedResult,
            $domain->buildUrl()
        );
    }

    /**
     * @return string[][]
     */
    public function domainProvider()
    {
        return [
            'empty_string' => [
                'domain' => '',
                'namespace' => '',
                'expected' => '/?rest_route=/'
            ],
            'https_domain' => [
                'domain' => 'https://www.test.com',
                'namespace' => '/v1',
                'expected' => 'https://www.test.com/?rest_route=/v1'
            ],
            'https_domain_with_backslash' => [
                'domain' => 'https://www.test.com/',
                'namespace' => '/v1',
                'expected' => 'https://www.test.com/?rest_route=/v1'
            ],
            'https_domain_with_backslash_for_domain_and_namespace' => [
                'domain' => 'https://www.test.com/',
                'namespace' => '/v1/',
                'expected' => 'https://www.test.com/?rest_route=/v1'
            ]
        ];
    }
}
