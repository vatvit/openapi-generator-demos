# TicTacToeApi\Api\StatisticsApiInterface

All URIs are relative to *https://api.tictactoe.example.com/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**getLeaderboard**](StatisticsApiInterface.md#getLeaderboard) | **GET** /leaderboard | Get leaderboard
[**getPlayerStats**](StatisticsApiInterface.md#getPlayerStats) | **GET** /players/{playerId}/stats | Get player statistics


## Service Declaration
```yaml
# config/services.yaml
services:
    # ...
    Acme\MyBundle\Api\StatisticsApi:
        tags:
            - { name: "open_api_server.api", api: "statistics" }
    # ...
```

## **getLeaderboard**
> TicTacToeApi\Model\Leaderboard getLeaderboard($timeframe, $limit)

Get leaderboard

Retrieves the global leaderboard with top players.

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/StatisticsApiInterface.php

namespace Acme\MyBundle\Api;

use TicTacToeApi\Api\StatisticsApiInterface;

class StatisticsApi implements StatisticsApiInterface
{

    // ...

    /**
     * Implementation of StatisticsApiInterface#getLeaderboard
     */
    public function getLeaderboard(string $timeframe, int $limit, int &$responseCode, array &$responseHeaders): array|object|null
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **timeframe** | **string**| Timeframe for leaderboard statistics | [optional] [default to &#39;all-time&#39;]
 **limit** | **int**| Number of top players to return | [optional] [default to 10]

### Return type

[**TicTacToeApi\Model\Leaderboard**](../Model/Leaderboard.md)

### Authorization

No authorization required

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **getPlayerStats**
> TicTacToeApi\Model\PlayerStats getPlayerStats($playerId)

Get player statistics

Retrieves comprehensive statistics for a player.

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/StatisticsApiInterface.php

namespace Acme\MyBundle\Api;

use TicTacToeApi\Api\StatisticsApiInterface;

class StatisticsApi implements StatisticsApiInterface
{

    // ...

    /**
     * Implementation of StatisticsApiInterface#getPlayerStats
     */
    public function getPlayerStats(string $playerId, int &$responseCode, array &$responseHeaders): array|object|null
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **playerId** | **string**| Unique player identifier |

### Return type

[**TicTacToeApi\Model\PlayerStats**](../Model/PlayerStats.md)

### Authorization

[bearerHttpAuthentication](../../README.md#bearerHttpAuthentication)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

