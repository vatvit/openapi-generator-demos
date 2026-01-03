<?php

declare(strict_types=1);

namespace TictactoeApi;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use TictactoeApi\DependencyInjection\Compiler\OpenAPIServerApiPass;

/**
 * OpenAPIServerBundle
 *
 * Symfony Bundle for OpenAPI server.
 * Auto-generated from OpenAPI specification.
 */
class OpenAPIServerBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new OpenAPIServerApiPass());
    }
}
