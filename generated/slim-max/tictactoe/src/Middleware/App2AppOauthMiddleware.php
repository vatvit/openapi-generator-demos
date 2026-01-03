<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * App2AppOauthMiddleware
 *
 * PSR-15 middleware for oauth2 authentication.
 * Implement the authenticate() method to provide your authentication logic.
 *
 * Security Scheme Type: oauth2
 *
 * @generated
 */
abstract class App2AppOauthMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // Extract OAuth2 access token
        $authorization = $request->getHeaderLine('Authorization');

        if (empty($authorization) || !str_starts_with($authorization, 'Bearer ')) {
            return $this->unauthorizedResponse('OAuth2 access token required');
        }

        $token = substr($authorization, 7);

        if (empty($token)) {
            return $this->unauthorizedResponse('Invalid access token');
        }

        $user = $this->authenticate($token);

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
     * @param string $token The OAuth2 access token
     * @return mixed User data if authenticated, null otherwise
     */
    abstract protected function authenticate(string $token): mixed;

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
