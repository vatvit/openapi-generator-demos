# TictactoeApi\StatisticsApi

All URIs are relative to https://api.tictactoe.example.com/v1, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**getLeaderboard()**](StatisticsApi.md#getLeaderboard) | **GET** /leaderboard | Get leaderboard |
| [**getPlayerStats()**](StatisticsApi.md#getPlayerStats) | **GET** /players/{playerId}/stats | Get player statistics |


## `getLeaderboard()`

```php
getLeaderboard($timeframe, $limit): \TictactoeApi\Model\Leaderboard
```

Get leaderboard

Retrieves the global leaderboard with top players.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new TictactoeApi\Api\StatisticsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$timeframe = 'all-time'; // string | Timeframe for leaderboard statistics
$limit = 10; // int | Number of top players to return

try {
    $result = $apiInstance->getLeaderboard($timeframe, $limit);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling StatisticsApi->getLeaderboard: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **timeframe** | **string**| Timeframe for leaderboard statistics | [optional] [default to &#39;all-time&#39;] |
| **limit** | **int**| Number of top players to return | [optional] [default to 10] |

### Return type

[**\TictactoeApi\Model\Leaderboard**](../Model/Leaderboard.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getPlayerStats()`

```php
getPlayerStats($player_id): \TictactoeApi\Model\PlayerStats
```

Get player statistics

Retrieves comprehensive statistics for a player.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (JWT) authorization: bearerHttpAuthentication
$config = TictactoeApi\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new TictactoeApi\Api\StatisticsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$player_id = 'player_id_example'; // string | Unique player identifier

try {
    $result = $apiInstance->getPlayerStats($player_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling StatisticsApi->getPlayerStats: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **player_id** | **string**| Unique player identifier | |

### Return type

[**\TictactoeApi\Model\PlayerStats**](../Model/PlayerStats.md)

### Authorization

[bearerHttpAuthentication](../../README.md#bearerHttpAuthentication)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
