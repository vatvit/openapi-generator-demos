# TictactoeApi\Api\GameManagementApiInterface

All URIs are relative to *https://api.tictactoe.example.com/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**createGame**](GameManagementApiInterface.md#createGame) | **POST** /games | Create a new game
[**deleteGame**](GameManagementApiInterface.md#deleteGame) | **DELETE** /games/{gameId} | Delete a game
[**getGame**](GameManagementApiInterface.md#getGame) | **GET** /games/{gameId} | Get game details
[**listGames**](GameManagementApiInterface.md#listGames) | **GET** /games | List all games


## Service Declaration
```yaml
# config/services.yaml
services:
    # ...
    Acme\MyBundle\Api\GameManagementApi:
        tags:
            - { name: "open_api_server.api", api: "gameManagement" }
    # ...
```

## **createGame**
> TictactoeApi\Model\Game createGame($createGameRequest)

Create a new game

Creates a new TicTacToe game with specified configuration.

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/GameManagementApiInterface.php

namespace Acme\MyBundle\Api;

use TictactoeApi\Api\GameManagementApiInterface;

class GameManagementApi implements GameManagementApiInterface
{

    // ...

    /**
     * Implementation of GameManagementApiInterface#createGame
     */
    public function createGame(CreateGameRequest $createGameRequest, int &$responseCode, array &$responseHeaders): array|object|null
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **createGameRequest** | [**TictactoeApi\Model\CreateGameRequest**](../Model/CreateGameRequest.md)|  |

### Return type

[**TictactoeApi\Model\Game**](../Model/Game.md)

### Authorization

[bearerHttpAuthentication](../../README.md#bearerHttpAuthentication)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **deleteGame**
> deleteGame($gameId)

Delete a game

Deletes a game. Only allowed for game creators or admins.

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/GameManagementApiInterface.php

namespace Acme\MyBundle\Api;

use TictactoeApi\Api\GameManagementApiInterface;

class GameManagementApi implements GameManagementApiInterface
{

    // ...

    /**
     * Implementation of GameManagementApiInterface#deleteGame
     */
    public function deleteGame(string $gameId, int &$responseCode, array &$responseHeaders): void
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

void (empty response body)

### Authorization

[bearerHttpAuthentication](../../README.md#bearerHttpAuthentication)

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
// src/Acme/MyBundle/Api/GameManagementApiInterface.php

namespace Acme\MyBundle\Api;

use TictactoeApi\Api\GameManagementApiInterface;

class GameManagementApi implements GameManagementApiInterface
{

    // ...

    /**
     * Implementation of GameManagementApiInterface#getGame
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

## **listGames**
> TictactoeApi\Model\GameListResponse listGames($page, $limit, $status, $playerId)

List all games

Retrieves a paginated list of games with optional filtering.

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/GameManagementApiInterface.php

namespace Acme\MyBundle\Api;

use TictactoeApi\Api\GameManagementApiInterface;

class GameManagementApi implements GameManagementApiInterface
{

    // ...

    /**
     * Implementation of GameManagementApiInterface#listGames
     */
    public function listGames(int $page, int $limit, ?GameStatus $status, ?string $playerId, int &$responseCode, array &$responseHeaders): array|object|null
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **page** | **int**| Page number for pagination | [optional] [default to 1]
 **limit** | **int**| Number of items per page | [optional] [default to 20]
 **status** | [**TictactoeApi\Model\GameStatus**](../Model/.md)| Filter by game status | [optional]
 **playerId** | **string**| Filter games by player ID | [optional]

### Return type

[**TictactoeApi\Model\GameListResponse**](../Model/GameListResponse.md)

### Authorization

[bearerHttpAuthentication](../../README.md#bearerHttpAuthentication)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

