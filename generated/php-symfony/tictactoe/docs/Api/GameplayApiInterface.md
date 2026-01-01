# TictactoeApi\Api\GameplayApiInterface

All URIs are relative to *https://api.tictactoe.example.com/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**getBoard**](GameplayApiInterface.md#getBoard) | **GET** /games/{gameId}/board | Get the game board
[**getGame**](GameplayApiInterface.md#getGame) | **GET** /games/{gameId} | Get game details
[**getMoves**](GameplayApiInterface.md#getMoves) | **GET** /games/{gameId}/moves | Get move history
[**getSquare**](GameplayApiInterface.md#getSquare) | **GET** /games/{gameId}/board/{row}/{column} | Get a single board square
[**putSquare**](GameplayApiInterface.md#putSquare) | **PUT** /games/{gameId}/board/{row}/{column} | Set a single board square


## Service Declaration
```yaml
# config/services.yaml
services:
    # ...
    Acme\MyBundle\Api\GameplayApi:
        tags:
            - { name: "open_api_server.api", api: "gameplay" }
    # ...
```

## **getBoard**
> TictactoeApi\Model\Status getBoard($gameId)

Get the game board

Retrieves the current state of the board and the winner.

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/GameplayApiInterface.php

namespace Acme\MyBundle\Api;

use TictactoeApi\Api\GameplayApiInterface;

class GameplayApi implements GameplayApiInterface
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
     * Implementation of GameplayApiInterface#getBoard
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

## **getGame**
> TictactoeApi\Model\Game getGame($gameId)

Get game details

Retrieves detailed information about a specific game.

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/GameplayApiInterface.php

namespace Acme\MyBundle\Api;

use TictactoeApi\Api\GameplayApiInterface;

class GameplayApi implements GameplayApiInterface
{

    // ...

    /**
     * Implementation of GameplayApiInterface#getGame
     */
    public function getGame(string $gameId, int &$responseCode, array &$responseHeaders): array|object|null
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

[**TictactoeApi\Model\Game**](../Model/Game.md)

### Authorization

[bearerHttpAuthentication](../../README.md#bearerHttpAuthentication)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **getMoves**
> TictactoeApi\Model\MoveHistory getMoves($gameId)

Get move history

Retrieves the complete move history for a game.

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/GameplayApiInterface.php

namespace Acme\MyBundle\Api;

use TictactoeApi\Api\GameplayApiInterface;

class GameplayApi implements GameplayApiInterface
{

    // ...

    /**
     * Implementation of GameplayApiInterface#getMoves
     */
    public function getMoves(string $gameId, int &$responseCode, array &$responseHeaders): array|object|null
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

[**TictactoeApi\Model\MoveHistory**](../Model/MoveHistory.md)

### Authorization

[bearerHttpAuthentication](../../README.md#bearerHttpAuthentication)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **getSquare**
> TictactoeApi\Model\SquareResponse getSquare($gameId, $row, $column)

Get a single board square

Retrieves the requested square.

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/GameplayApiInterface.php

namespace Acme\MyBundle\Api;

use TictactoeApi\Api\GameplayApiInterface;

class GameplayApi implements GameplayApiInterface
{

    /**
     * Configure OAuth2 access token for authorization: user2AppOauth
     */
    public function setuser2AppOauth($oauthToken)
    {
        // Retrieve logged in user from $oauthToken ...
    }

    // ...

    /**
     * Implementation of GameplayApiInterface#getSquare
     */
    public function getSquare(string $gameId, int $row, int $column, int &$responseCode, array &$responseHeaders): array|object|null
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
 **row** | **int**| Board row (vertical coordinate) |
 **column** | **int**| Board column (horizontal coordinate) |

### Return type

[**TictactoeApi\Model\SquareResponse**](../Model/SquareResponse.md)

### Authorization

[bearerHttpAuthentication](../../README.md#bearerHttpAuthentication), [user2AppOauth](../../README.md#user2AppOauth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **putSquare**
> TictactoeApi\Model\Status putSquare($gameId, $row, $column, $moveRequest)

Set a single board square

Places a mark on the board and retrieves the whole board and the winner (if any).

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/GameplayApiInterface.php

namespace Acme\MyBundle\Api;

use TictactoeApi\Api\GameplayApiInterface;

class GameplayApi implements GameplayApiInterface
{

    /**
     * Configure OAuth2 access token for authorization: user2AppOauth
     */
    public function setuser2AppOauth($oauthToken)
    {
        // Retrieve logged in user from $oauthToken ...
    }

    // ...

    /**
     * Implementation of GameplayApiInterface#putSquare
     */
    public function putSquare(string $gameId, int $row, int $column, MoveRequest $moveRequest, int &$responseCode, array &$responseHeaders): array|object|null
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
 **row** | **int**| Board row (vertical coordinate) |
 **column** | **int**| Board column (horizontal coordinate) |
 **moveRequest** | [**TictactoeApi\Model\MoveRequest**](../Model/MoveRequest.md)|  |

### Return type

[**TictactoeApi\Model\Status**](../Model/Status.md)

### Authorization

[bearerHttpAuthentication](../../README.md#bearerHttpAuthentication), [user2AppOauth](../../README.md#user2AppOauth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

