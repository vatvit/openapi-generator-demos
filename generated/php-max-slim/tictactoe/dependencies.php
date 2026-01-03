<?php

declare(strict_types=1);

/**
 * Slim Framework Dependencies Configuration
 *
 * Auto-generated from OpenAPI specification.
 * Configure these dependencies in your DI container.
 *
 * Usage with PHP-DI:
 * ```php
 * $containerBuilder = new \DI\ContainerBuilder();
 * $containerBuilder->addDefinitions(__DIR__ . '/dependencies.php');
 * $container = $containerBuilder->build();
 * ```
 *
 * @generated
 */

use Psr\Container\ContainerInterface;

return [
    // ============================================================
    // CreateGameApi Dependencies
    // ============================================================

    // Service Interface binding
    // TODO: Bind your implementation class here
    TicTacToe\Api\CreateGameApiServiceInterface::class => \DI\autowire(
        // Replace with your implementation:
        // \App\Service\CreateGameApiService::class
    ),

    // Handler: createGame
    TicTacToe\Handler\CreateGameHandler::class => \DI\autowire()
        ->constructorParameter('service', \DI\get(TicTacToe\Api\CreateGameApiServiceInterface::class)),

    // ============================================================
    // DeleteGameApi Dependencies
    // ============================================================

    // Service Interface binding
    // TODO: Bind your implementation class here
    TicTacToe\Api\DeleteGameApiServiceInterface::class => \DI\autowire(
        // Replace with your implementation:
        // \App\Service\DeleteGameApiService::class
    ),

    // Handler: deleteGame
    TicTacToe\Handler\DeleteGameHandler::class => \DI\autowire()
        ->constructorParameter('service', \DI\get(TicTacToe\Api\DeleteGameApiServiceInterface::class)),

    // ============================================================
    // GetBoardApi Dependencies
    // ============================================================

    // Service Interface binding
    // TODO: Bind your implementation class here
    TicTacToe\Api\GetBoardApiServiceInterface::class => \DI\autowire(
        // Replace with your implementation:
        // \App\Service\GetBoardApiService::class
    ),

    // Handler: getBoard
    TicTacToe\Handler\GetBoardHandler::class => \DI\autowire()
        ->constructorParameter('service', \DI\get(TicTacToe\Api\GetBoardApiServiceInterface::class)),

    // ============================================================
    // GetGameApi Dependencies
    // ============================================================

    // Service Interface binding
    // TODO: Bind your implementation class here
    TicTacToe\Api\GetGameApiServiceInterface::class => \DI\autowire(
        // Replace with your implementation:
        // \App\Service\GetGameApiService::class
    ),

    // Handler: getGame
    TicTacToe\Handler\GetGameHandler::class => \DI\autowire()
        ->constructorParameter('service', \DI\get(TicTacToe\Api\GetGameApiServiceInterface::class)),

    // ============================================================
    // GetLeaderboardApi Dependencies
    // ============================================================

    // Service Interface binding
    // TODO: Bind your implementation class here
    TicTacToe\Api\GetLeaderboardApiServiceInterface::class => \DI\autowire(
        // Replace with your implementation:
        // \App\Service\GetLeaderboardApiService::class
    ),

    // Handler: getLeaderboard
    TicTacToe\Handler\GetLeaderboardHandler::class => \DI\autowire()
        ->constructorParameter('service', \DI\get(TicTacToe\Api\GetLeaderboardApiServiceInterface::class)),

    // ============================================================
    // GetMovesApi Dependencies
    // ============================================================

    // Service Interface binding
    // TODO: Bind your implementation class here
    TicTacToe\Api\GetMovesApiServiceInterface::class => \DI\autowire(
        // Replace with your implementation:
        // \App\Service\GetMovesApiService::class
    ),

    // Handler: getMoves
    TicTacToe\Handler\GetMovesHandler::class => \DI\autowire()
        ->constructorParameter('service', \DI\get(TicTacToe\Api\GetMovesApiServiceInterface::class)),

    // ============================================================
    // GetPlayerStatsApi Dependencies
    // ============================================================

    // Service Interface binding
    // TODO: Bind your implementation class here
    TicTacToe\Api\GetPlayerStatsApiServiceInterface::class => \DI\autowire(
        // Replace with your implementation:
        // \App\Service\GetPlayerStatsApiService::class
    ),

    // Handler: getPlayerStats
    TicTacToe\Handler\GetPlayerStatsHandler::class => \DI\autowire()
        ->constructorParameter('service', \DI\get(TicTacToe\Api\GetPlayerStatsApiServiceInterface::class)),

    // ============================================================
    // GetSquareApi Dependencies
    // ============================================================

    // Service Interface binding
    // TODO: Bind your implementation class here
    TicTacToe\Api\GetSquareApiServiceInterface::class => \DI\autowire(
        // Replace with your implementation:
        // \App\Service\GetSquareApiService::class
    ),

    // Handler: getSquare
    TicTacToe\Handler\GetSquareHandler::class => \DI\autowire()
        ->constructorParameter('service', \DI\get(TicTacToe\Api\GetSquareApiServiceInterface::class)),

    // ============================================================
    // ListGamesApi Dependencies
    // ============================================================

    // Service Interface binding
    // TODO: Bind your implementation class here
    TicTacToe\Api\ListGamesApiServiceInterface::class => \DI\autowire(
        // Replace with your implementation:
        // \App\Service\ListGamesApiService::class
    ),

    // Handler: listGames
    TicTacToe\Handler\ListGamesHandler::class => \DI\autowire()
        ->constructorParameter('service', \DI\get(TicTacToe\Api\ListGamesApiServiceInterface::class)),

    // ============================================================
    // PutSquareApi Dependencies
    // ============================================================

    // Service Interface binding
    // TODO: Bind your implementation class here
    TicTacToe\Api\PutSquareApiServiceInterface::class => \DI\autowire(
        // Replace with your implementation:
        // \App\Service\PutSquareApiService::class
    ),

    // Handler: putSquare
    TicTacToe\Handler\PutSquareHandler::class => \DI\autowire()
        ->constructorParameter('service', \DI\get(TicTacToe\Api\PutSquareApiServiceInterface::class)),

];
