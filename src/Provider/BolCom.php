<?php

namespace Mirkin1993\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Tool\BearerAuthorizationTrait;
use Psr\Http\Message\ResponseInterface;

class BolCom extends AbstractProvider
{
    use BearerAuthorizationTrait;

    const BOL_API_URL = 'https://api.bol.com';

    private $bolApiUrl = self::BOL_API_URL;

    public function setBolApiUrl($url)
    {
        $this->bolApiUrl = $url;

        return $this;
    }

    public function getBaseAuthorizationUrl()
    {
        return '';
    }

    public function getBaseAccessTokenUrl(array $params)
    {
        return 'https://login.bol.com/token';
    }

    public function getResourceOwnerDetailsUrl(AccessToken $token)
    {
        return '';
    }

    protected function getDefaultScopes()
    {
        return ['RETAILER'];
    }

    protected function checkResponse(ResponseInterface $response, $data)
    {
        if (isset($data['error'])) {
            $statusCode = $response->getStatusCode();
            $error = $data['error'];
            $errorDescription = $data['error_description'];
            $errorLink = (isset($data['error_uri']) ? $data['error_uri'] : false);
            throw new IdentityProviderException(
                $statusCode . ' - ' . $errorDescription . ': ' . $error . ($errorLink ? ' (see: ' . $errorLink . ')' : ''),
                $response->getStatusCode(),
                $response
            );
        }
    }

    protected function createResourceOwner(array $response, AccessToken $token)
    {
        return '';
    }
}