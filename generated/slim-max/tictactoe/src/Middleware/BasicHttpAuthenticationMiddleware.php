<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * BasicHttpAuthenticationMiddleware
 *
 * PSR-15 middleware for http authentication.
 * Implement the authenticate() method to provide your authentication logic.
 *
 * Security Scheme Type: http
 * Description: Basic HTTP Authentication
 *
 * @generated
 */
abstract class BasicHttpAuthenticationMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // Extract Basic authentication credentials
        $authorization = $request->getHeaderLine('Authorization');

        if (empty($authorization) || !str_starts_with($authorization, 'Basic ')) {
            return $this->unauthorizedResponse('Basic authentication required');
        }

        $credentials = base64_decode(substr($authorization, 6));
        [$username, $password] = explode(':', $credentials, 2) + [null, null];

        if (empty($username)) {
            return $this->unauthorizedResponse('Invalid credentials');
        }

        $user = $this->authenticate($username, $password);

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
     * @param string $username The username
     * @param string|null $password The password
     * @return mixed User data if authenticated, null otherwise
     */
    abstract protected function authenticate(string $username, ?string $password): mixed;

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
