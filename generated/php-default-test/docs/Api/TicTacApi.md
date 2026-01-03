# TictactoeApi\TicTacApi

All URIs are relative to https://api.tictactoe.example.com/v1, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**getBoard()**](TicTacApi.md#getBoard) | **GET** /games/{gameId}/board | Get the game board |


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


$apiInstance = new TictactoeApi\Api\TicTacApi(
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
    echo 'Exception when calling TicTacApi->getBoard: ', $e->getMessage(), PHP_EOL;
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
