# OpenAPIClient-php

This API allows writing down marks on a Tic Tac Toe board
and requesting the state of the board or of individual squares.



## Installation & Usage

### Requirements

PHP 7.4 and later.
Should also work with PHP 8.0.

### Composer

To install the bindings via [Composer](https://getcomposer.org/), add the following to `composer.json`:

```json
{
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/GIT_USER_ID/GIT_REPO_ID.git"
    }
  ],
  "require": {
    "GIT_USER_ID/GIT_REPO_ID": "*@dev"
  }
}
```

Then run `composer install`

### Manual Installation

Download the files and include `autoload.php`:

```php
<?php
require_once('/path/to/OpenAPIClient-php/vendor/autoload.php');
```

## Getting Started

Please follow the [installation procedure](#installation--usage) and then run the following:

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

## API Endpoints

All URIs are relative to *https://api.tictactoe.example.com/v1*

Class | Method | HTTP request | Description
------------ | ------------- | ------------- | -------------
*GameManagementApi* | [**createGame**](docs/Api/GameManagementApi.md#creategame) | **POST** /games | Create a new game
*GameManagementApi* | [**deleteGame**](docs/Api/GameManagementApi.md#deletegame) | **DELETE** /games/{gameId} | Delete a game
*GameManagementApi* | [**getGame**](docs/Api/GameManagementApi.md#getgame) | **GET** /games/{gameId} | Get game details
*GameManagementApi* | [**listGames**](docs/Api/GameManagementApi.md#listgames) | **GET** /games | List all games
*GameplayApi* | [**getBoard**](docs/Api/GameplayApi.md#getboard) | **GET** /games/{gameId}/board | Get the game board
*GameplayApi* | [**getGame**](docs/Api/GameplayApi.md#getgame) | **GET** /games/{gameId} | Get game details
*GameplayApi* | [**getMoves**](docs/Api/GameplayApi.md#getmoves) | **GET** /games/{gameId}/moves | Get move history
*GameplayApi* | [**getSquare**](docs/Api/GameplayApi.md#getsquare) | **GET** /games/{gameId}/board/{row}/{column} | Get a single board square
*GameplayApi* | [**putSquare**](docs/Api/GameplayApi.md#putsquare) | **PUT** /games/{gameId}/board/{row}/{column} | Set a single board square
*StatisticsApi* | [**getLeaderboard**](docs/Api/StatisticsApi.md#getleaderboard) | **GET** /leaderboard | Get leaderboard
*StatisticsApi* | [**getPlayerStats**](docs/Api/StatisticsApi.md#getplayerstats) | **GET** /players/{playerId}/stats | Get player statistics
*TicTacApi* | [**getBoard**](docs/Api/TicTacApi.md#getboard) | **GET** /games/{gameId}/board | Get the game board

## Models

- [BadRequestError](docs/Model/BadRequestError.md)
- [CreateGameRequest](docs/Model/CreateGameRequest.md)
- [Error](docs/Model/Error.md)
- [ForbiddenError](docs/Model/ForbiddenError.md)
- [Game](docs/Model/Game.md)
- [GameListResponse](docs/Model/GameListResponse.md)
- [GameMode](docs/Model/GameMode.md)
- [GameStatus](docs/Model/GameStatus.md)
- [Leaderboard](docs/Model/Leaderboard.md)
- [LeaderboardEntry](docs/Model/LeaderboardEntry.md)
- [Mark](docs/Model/Mark.md)
- [Move](docs/Model/Move.md)
- [MoveHistory](docs/Model/MoveHistory.md)
- [MoveRequest](docs/Model/MoveRequest.md)
- [NotFoundError](docs/Model/NotFoundError.md)
- [Pagination](docs/Model/Pagination.md)
- [Player](docs/Model/Player.md)
- [PlayerStats](docs/Model/PlayerStats.md)
- [SquareResponse](docs/Model/SquareResponse.md)
- [Status](docs/Model/Status.md)
- [UnauthorizedError](docs/Model/UnauthorizedError.md)
- [ValidationError](docs/Model/ValidationError.md)
- [ValidationErrorAllOfErrors](docs/Model/ValidationErrorAllOfErrors.md)
- [Winner](docs/Model/Winner.md)

## Authorization

Authentication schemes defined for the API:
### defaultApiKey

- **Type**: API key
- **API key parameter name**: api-key
- **Location**: HTTP header


### basicHttpAuthentication

- **Type**: HTTP basic authentication

### bearerHttpAuthentication

- **Type**: Bearer authentication (JWT)

### app2AppOauth

- **Type**: `OAuth`
- **Flow**: `application`
- **Authorization URL**: ``
- **Scopes**: 
    - **board:read**: Read the board

### user2AppOauth

- **Type**: `OAuth`
- **Flow**: `accessCode`
- **Authorization URL**: `https://learn.openapis.org/oauth/2.0/auth`
- **Scopes**: 
    - **board:read**: Read the board
    - **board:write**: Write to the board

## Tests

To run the tests, use:

```bash
composer install
vendor/bin/phpunit
```

## Author



## About this package

This PHP package is automatically generated by the [OpenAPI Generator](https://openapi-generator.tech) project:

- API version: `1.0.0`
    - Generator version: `7.12.0`
- Build package: `org.openapitools.codegen.languages.PhpClientCodegen`
