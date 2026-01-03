# TictactoeApi\GameplayApi

All URIs are relative to https://api.tictactoe.example.com/v1, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**getBoard()**](GameplayApi.md#getBoard) | **GET** /games/{gameId}/board | Get the game board |
| [**getGame()**](GameplayApi.md#getGame) | **GET** /games/{gameId} | Get game details |
| [**getMoves()**](GameplayApi.md#getMoves) | **GET** /games/{gameId}/moves | Get move history |
| [**getSquare()**](GameplayApi.md#getSquare) | **GET** /games/{gameId}/board/{row}/{column} | Get a single board square |
| [**putSquare()**](GameplayApi.md#putSquare) | **PUT** /games/{gameId}/board/{row}/{column} | Set a single board square |


## `getBoard()`

```php
getBoard($game_id): \TictactoeApi\Model\Status
```

Get the game board

Retrieves the current state of the board and the winner.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure API key authorization: defaultApiKey
$config = TictactoeApi\Configuration::getDefaultConfiguration()->setApiKey('api-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = TictactoeApi\Configuration::getDefaultConfiguration()->setApiKeyPrefix('api-key', 'Bearer');

// Configure OAuth2 access token for authorization: app2AppOauth
$config = TictactoeApi\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new TictactoeApi\Api\GameplayApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$game_id = 'game_id_example'; // string | Unique game identifier

try {
    $result = $apiInstance->getBoard($game_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling GameplayApi->getBoard: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **game_id** | **string**| Unique game identifier | |

### Return type

[**\TictactoeApi\Model\Status**](../Model/Status.md)

### Authorization

[defaultApiKey](../../README.md#defaultApiKey), [app2AppOauth](../../README.md#app2AppOauth)

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


$apiInstance = new TictactoeApi\Api\GameplayApi(
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
    echo 'Exception when calling GameplayApi->getGame: ', $e->getMessage(), PHP_EOL;
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

## `getMoves()`

```php
getMoves($game_id): \TictactoeApi\Model\MoveHistory
```

Get move history

Retrieves the complete move history for a game.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (JWT) authorization: bearerHttpAuthentication
$config = TictactoeApi\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new TictactoeApi\Api\GameplayApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$game_id = 'game_id_example'; // string | Unique game identifier

try {
    $result = $apiInstance->getMoves($game_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling GameplayApi->getMoves: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **game_id** | **string**| Unique game identifier | |

### Return type

[**\TictactoeApi\Model\MoveHistory**](../Model/MoveHistory.md)

### Authorization

[bearerHttpAuthentication](../../README.md#bearerHttpAuthentication)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getSquare()`

```php
getSquare($game_id, $row, $column): \TictactoeApi\Model\SquareResponse
```

Get a single board square

Retrieves the requested square.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (JWT) authorization: bearerHttpAuthentication
$config = TictactoeApi\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

// Configure OAuth2 access token for authorization: user2AppOauth
$config = TictactoeApi\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new TictactoeApi\Api\GameplayApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$game_id = 'game_id_example'; // string | Unique game identifier
$row = 56; // int | Board row (vertical coordinate)
$column = 56; // int | Board column (horizontal coordinate)

try {
    $result = $apiInstance->getSquare($game_id, $row, $column);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling GameplayApi->getSquare: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **game_id** | **string**| Unique game identifier | |
| **row** | **int**| Board row (vertical coordinate) | |
| **column** | **int**| Board column (horizontal coordinate) | |

### Return type

[**\TictactoeApi\Model\SquareResponse**](../Model/SquareResponse.md)

### Authorization

[bearerHttpAuthentication](../../README.md#bearerHttpAuthentication), [user2AppOauth](../../README.md#user2AppOauth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `putSquare()`

```php
putSquare($game_id, $row, $column, $move_request): \TictactoeApi\Model\Status
```

Set a single board square

Places a mark on the board and retrieves the whole board and the winner (if any).

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (JWT) authorization: bearerHttpAuthentication
$config = TictactoeApi\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

// Configure OAuth2 access token for authorization: user2AppOauth
$config = TictactoeApi\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new TictactoeApi\Api\GameplayApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$game_id = 'game_id_example'; // string | Unique game identifier
$row = 56; // int | Board row (vertical coordinate)
$column = 56; // int | Board column (horizontal coordinate)
$move_request = new \TictactoeApi\Model\MoveRequest(); // \TictactoeApi\Model\MoveRequest

try {
    $result = $apiInstance->putSquare($game_id, $row, $column, $move_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling GameplayApi->putSquare: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **game_id** | **string**| Unique game identifier | |
| **row** | **int**| Board row (vertical coordinate) | |
| **column** | **int**| Board column (horizontal coordinate) | |
| **move_request** | [**\TictactoeApi\Model\MoveRequest**](../Model/MoveRequest.md)|  | |

### Return type

[**\TictactoeApi\Model\Status**](../Model/Status.md)

### Authorization

[bearerHttpAuthentication](../../README.md#bearerHttpAuthentication), [user2AppOauth](../../README.md#user2AppOauth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
