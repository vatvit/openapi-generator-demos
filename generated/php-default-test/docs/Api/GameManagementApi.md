# TictactoeApi\GameManagementApi

All URIs are relative to https://api.tictactoe.example.com/v1, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**createGame()**](GameManagementApi.md#createGame) | **POST** /games | Create a new game |
| [**deleteGame()**](GameManagementApi.md#deleteGame) | **DELETE** /games/{gameId} | Delete a game |
| [**getGame()**](GameManagementApi.md#getGame) | **GET** /games/{gameId} | Get game details |
| [**listGames()**](GameManagementApi.md#listGames) | **GET** /games | List all games |


## `createGame()`

```php
createGame($create_game_request): \TictactoeApi\Model\Game
```

Create a new game

Creates a new TicTacToe game with specified configuration.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (JWT) authorization: bearerHttpAuthentication
$config = TictactoeApi\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new TictactoeApi\Api\GameManagementApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$create_game_request = new \TictactoeApi\Model\CreateGameRequest(); // \TictactoeApi\Model\CreateGameRequest

try {
    $result = $apiInstance->createGame($create_game_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling GameManagementApi->createGame: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **create_game_request** | [**\TictactoeApi\Model\CreateGameRequest**](../Model/CreateGameRequest.md)|  | |

### Return type

[**\TictactoeApi\Model\Game**](../Model/Game.md)

### Authorization

[bearerHttpAuthentication](../../README.md#bearerHttpAuthentication)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `deleteGame()`

```php
deleteGame($game_id)
```

Delete a game

Deletes a game. Only allowed for game creators or admins.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (JWT) authorization: bearerHttpAuthentication
$config = TictactoeApi\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new TictactoeApi\Api\GameManagementApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$game_id = 'game_id_example'; // string | Unique game identifier

try {
    $apiInstance->deleteGame($game_id);
} catch (Exception $e) {
    echo 'Exception when calling GameManagementApi->deleteGame: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **game_id** | **string**| Unique game identifier | |

### Return type

void (empty response body)

### Authorization

[bearerHttpAuthentication](../../README.md#bearerHttpAuthentication)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getGame()`

```php
getGame($game_id): \TictactoeApi\Model\Game
```

Get game details

Retrieves detailed information about a specific game.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (JWT) authorization: bearerHttpAuthentication
$config = TictactoeApi\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new TictactoeApi\Api\GameManagementApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$game_id = 'game_id_example'; // string | Unique game identifier

try {
    $result = $apiInstance->getGame($game_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling GameManagementApi->getGame: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **game_id** | **string**| Unique game identifier | |

### Return type

[**\TictactoeApi\Model\Game**](../Model/Game.md)

### Authorization

[bearerHttpAuthentication](../../README.md#bearerHttpAuthentication)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `listGames()`

```php
listGames($page, $limit, $status, $player_id): \TictactoeApi\Model\GameListResponse
```

List all games

Retrieves a paginated list of games with optional filtering.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (JWT) authorization: bearerHttpAuthentication
$config = TictactoeApi\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new TictactoeApi\Api\GameManagementApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$page = 1; // int | Page number for pagination
$limit = 20; // int | Number of items per page
$status = new \TictactoeApi\Model\\TictactoeApi\Model\GameStatus(); // \TictactoeApi\Model\GameStatus | Filter by game status
$player_id = 'player_id_example'; // string | Filter games by player ID

try {
    $result = $apiInstance->listGames($page, $limit, $status, $player_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling GameManagementApi->listGames: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **page** | **int**| Page number for pagination | [optional] [default to 1] |
| **limit** | **int**| Number of items per page | [optional] [default to 20] |
| **status** | [**\TictactoeApi\Model\GameStatus**](../Model/.md)| Filter by game status | [optional] |
| **player_id** | **string**| Filter games by player ID | [optional] |

### Return type

[**\TictactoeApi\Model\GameListResponse**](../Model/GameListResponse.md)

### Authorization

[bearerHttpAuthentication](../../README.md#bearerHttpAuthentication)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
