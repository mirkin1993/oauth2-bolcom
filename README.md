# Bol.com Provider for OAuth 2.0 Client

This package provides Bol.com OAuth 2.0 support for the PHP League's [OAuth 2.0 Client](https://github.com/thephpleague/oauth2-client).

## Installation

```
composer require mirkin1993/oauth2-bolcom
```

## Usage

```php
$bolComProvider= = new \Mirkin1993\OAuth2\Client\Provider\Amazon([
    'clientId'                => 'yourClientId',          // The client ID assigned to you by Bol.com
    'clientSecret'            => 'yourSecret',      // The client secret assigned to you by Bol.com
]);

// Get client credentials
try {
    // Try to get an access token using the client credentials grant.
    $accessToken = $bolComProvider->getAccessToken('client_credentials');
    
} catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {

    // Failed to get the access token
    exit($e->getMessage());
}
```

For more information see the PHP League's general usage examples.

## Testing

``` bash
$ ./vendor/bin/phpunit
```

## License

The MIT License (MIT). Please see [License File](https://github.com/mirkin1993/oauth2-bolcom/blob/master/LICENSE) for more information.
