<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * DefaultApiKeyMiddleware
 *
 * PSR-15 middleware for apiKey authentication.
 * Implement the authenticate() method to provide your authentication logic.
 *
 * Security Scheme Type: apiKey
 * Description: API key provided in console
 *
 * @generated
 */
abstract class DefaultApiKeyMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // Extract API key from header: api-key
        $apiKey = $request->getHeaderLine('api-key');

        if (empty($apiKey)) {
            return $this->unauthorizedResponse('API key is required');
        }

        $user = $this->authenticate($apiKey);

        if ($user === null) {
            return $this->unauthorizedResponse('Authentication failed');
        }

        // Add authenticated user to request attributes
        $request = $request->withAttribute('user', $user);

        return $handler->handle($request);
    }

    /**
     * Authenticate the request and return user data or null if authentication fails.
     *
     * @param string $apiKey The API key
     * @return mixed User data if authenticated, null otherwise
     */
    abstract protected function authenticate(string $apiKey): mixed;

    /**
     * Create an unauthorized response
     */
    protected function unauthorizedResponse(string $message): ResponseInterface
    {
        $response = new \Slim\Psr7\Response(401);
        $response->getBody()->write(json_encode([
            'error' => 'Unauthorized',
            'message' => $message
        ], JSON_THROW_ON_ERROR));
        return $response->withHeader('Content-Type', 'application/json');
    }
}
