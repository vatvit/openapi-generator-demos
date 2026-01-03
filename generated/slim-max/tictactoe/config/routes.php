<?php

declare(strict_types=1);

/**
 * Slim Framework Routes
 *
 * Auto-generated from OpenAPI specification.
 * Register these routes with your Slim application.
 *
 * Usage:
 * ```php
 * $app = \Slim\Factory\AppFactory::create();
 * (require __DIR__ . '/routes.php')($app);
 * $app->run();
 * ```
 *
 * @generated
 */

use Slim\App;

return function (App $app): void {
    /**
     * post /games
     * Create a new game
     *
     * Security: bearerHttpAuthentication
     */
    $app->post('/games', \TictactoeApi\Api\Handler\CreateGameHandler::class)
        ->setName('createGame')
        ->add(\TictactoeApi\Api\Middleware\AuthMiddleware::class);

    /**
     * delete /games/{gameId}
     * Delete a game
     *
     * Security: bearerHttpAuthentication
     */
    $app->delete('/games/{gameId}', \TictactoeApi\Api\Handler\DeleteGameHandler::class)
        ->setName('deleteGame')
        ->add(\TictactoeApi\Api\Middleware\AuthMiddleware::class);

    /**
     * get /games/{gameId}
     * Get game details
     *
     * Security: bearerHttpAuthentication
     */
    $app->get('/games/{gameId}', \TictactoeApi\Api\Handler\GetGameHandler::class)
        ->setName('getGame')
        ->add(\TictactoeApi\Api\Middleware\AuthMiddleware::class);

    /**
     * get /games
     * List all games
     *
     * Security: bearerHttpAuthentication
     */
    $app->get('/games', \TictactoeApi\Api\Handler\ListGamesHandler::class)
        ->setName('listGames')
        ->add(\TictactoeApi\Api\Middleware\AuthMiddleware::class);

    /**
     * get /games/{gameId}/board
     * Get the game board
     *
     * Security: defaultApiKey, app2AppOauth
     */
    $app->get('/games/{gameId}/board', \TictactoeApi\Api\Handler\GetBoardHandler::class)
        ->setName('getBoard')
        ->add(\TictactoeApi\Api\Middleware\AuthMiddleware::class);

    /**
     * get /games/{gameId}/moves
     * Get move history
     *
     * Security: bearerHttpAuthentication
     */
    $app->get('/games/{gameId}/moves', \TictactoeApi\Api\Handler\GetMovesHandler::class)
        ->setName('getMoves')
        ->add(\TictactoeApi\Api\Middleware\AuthMiddleware::class);

    /**
     * get /games/{gameId}/board/{row}/{column}
     * Get a single board square
     *
     * Security: bearerHttpAuthentication, user2AppOauth
     */
    $app->get('/games/{gameId}/board/{row}/{column}', \TictactoeApi\Api\Handler\GetSquareHandler::class)
        ->setName('getSquare')
        ->add(\TictactoeApi\Api\Middleware\AuthMiddleware::class);

    /**
     * put /games/{gameId}/board/{row}/{column}
     * Set a single board square
     *
     * Security: bearerHttpAuthentication, user2AppOauth
     */
    $app->put('/games/{gameId}/board/{row}/{column}', \TictactoeApi\Api\Handler\PutSquareHandler::class)
        ->setName('putSquare')
        ->add(\TictactoeApi\Api\Middleware\AuthMiddleware::class);

    /**
     * get /leaderboard
     * Get leaderboard
     */
    $app->get('/leaderboard', \TictactoeApi\Api\Handler\GetLeaderboardHandler::class)
        ->setName('getLeaderboard');

    /**
     * get /players/{playerId}/stats
     * Get player statistics
     *
     * Security: bearerHttpAuthentication
     */
    $app->get('/players/{playerId}/stats', \TictactoeApi\Api\Handler\GetPlayerStatsHandler::class)
        ->setName('getPlayerStats')
        ->add(\TictactoeApi\Api\Middleware\AuthMiddleware::class);

};
