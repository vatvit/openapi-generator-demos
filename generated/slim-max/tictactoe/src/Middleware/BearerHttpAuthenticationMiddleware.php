<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * BearerHttpAuthenticationMiddleware
 *
 * PSR-15 middleware for http authentication.
 * Implement the authenticate() method to provide your authentication logic.
 *
 * Security Scheme Type: http
 * Description: Bearer token using a JWT
 *
 * @generated
 */
abstract class BearerHttpAuthenticationMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // Extract Bearer token
        $authorization = $request->getHeaderLine('Authorization');

        if (empty($authorization) || !str_starts_with($authorization, 'Bearer ')) {
            return $this->unauthorizedResponse('Bearer token required');
        }

        $token = substr($authorization, 7);

        if (empty($token)) {
            return $this->unauthorizedResponse('Invalid token');
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
     * @param string $token The bearer token
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
