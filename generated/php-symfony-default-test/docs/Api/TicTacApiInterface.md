# TictactoeApi\Api\TicTacApiInterface

All URIs are relative to *https://api.tictactoe.example.com/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**getBoard**](TicTacApiInterface.md#getBoard) | **GET** /games/{gameId}/board | Get the game board


## Service Declaration
```yaml
# config/services.yaml
services:
    # ...
    Acme\MyBundle\Api\TicTacApi:
        tags:
            - { name: "open_api_server.api", api: "ticTac" }
    # ...
```

## **getBoard**
> TictactoeApi\Model\Status getBoard($gameId)

Get the game board

Retrieves the current state of the board and the winner.

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/TicTacApiInterface.php

namespace Acme\MyBundle\Api;

use TictactoeApi\Api\TicTacApiInterface;

class TicTacApi implements TicTacApiInterface
{

    /**
     * Configure API key authorization: defaultApiKey
     */
    public function setdefaultApiKey($apiKey)
    {
        // Retrieve logged in user from $apiKey ...
    }

    /**
     * Configure OAuth2 access token for authorization: app2AppOauth
     */
    public function setapp2AppOauth($oauthToken)
    {
        // Retrieve logged in user from $oauthToken ...
    }

    // ...

    /**
     * Implementation of TicTacApiInterface#getBoard
     */
    public function getBoard(string $gameId, int &$responseCode, array &$responseHeaders): array|object|null
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **gameId** | **string**| Unique game identifier |

### Return type

[**TictactoeApi\Model\Status**](../Model/Status.md)

### Authorization

[defaultApiKey](../../README.md#defaultApiKey), [app2AppOauth](../../README.md#app2AppOauth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

