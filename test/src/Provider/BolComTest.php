<?php

namespace Mirkin1993\OAuth2\Client\Test\Provider;

use GuzzleHttp\ClientInterface;
use Mirkin1993\OAuth2\Client\Provider\BolCom;
use Mockery;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

class BolComTest extends TestCase
{
    public function testGetAccessToken()
    {
        $provider = new BolCom([
            'clientId' => 'mock_client_id',
            'clientSecret' => 'mock_secret',
        ]);

        $response = Mockery::mock(ResponseInterface::class);
        $response->shouldReceive('getHeader')
            ->once()
            ->andReturn('application/json');
        $response->shouldReceive('getBody')
            ->once()
            ->andReturn('{"token_type":"bearer","scope":"RETAILER","access_token":"mock_access_token",expires_in":1631007544}');

        $client = Mockery::mock(ClientInterface::class);
        $client->shouldReceive('send')->once()->andReturn($response);
        $provider->setHttpClient($client);

        $token = $provider->getAccessToken('client_credentials');

        $this->assertEquals('mock_access_token', $token->getToken());
        $this->assertNull($token->getExpires());
    }
}