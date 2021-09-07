<?php

namespace Mirkin1993\OAuth2\Client\Test\Provider;

use Mirkkin1993\Oauth2\Client\Provider\BolCom;
use Mockery as m;

class BolComTest extends \PHPUnit_Framework_TestCase
{
    protected $provider;

    protected function setUp()
    {
        $this->provider = new BolCom([
            'clientId' => 'mock_client_id',
            'clientSecret' => 'mock_secret',
        ]);
    }

    public function testGetAccessToken()
    {
        $response = m::mock('Psr\Http\Message\ResponseInterface');
        $response->shouldReceive('getHeader')
            ->times(1)
            ->andReturn('application/json');
        $response->shouldReceive('getBody')
            ->times(1)
            ->andReturn('{"token_type":"bearer","scope":"RETAILER","access_token":"mock_access_token",expires_in":1631007544}');

        $client = m::mock('GuzzleHttp\ClientInterface');
        $client->shouldReceive('send')->times(1)->andReturn($response);
        $this->provider->setHttpClient($client);

        $token = $this->provider->getAccessToken('client_credentials');

        $this->assertEquals('mock_access_token', $token->getToken());
        $this->assertLessThanOrEqual(time() + 1631007544, $token->getExpires());
        $this->assertGreaterThanOrEqual(time(), $token->getExpires());
    }
}