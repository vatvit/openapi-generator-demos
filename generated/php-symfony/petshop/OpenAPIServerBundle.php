<?php

declare(strict_types=1);

namespace PetshopApi;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use PetshopApi\DependencyInjection\Compiler\OpenAPIServerApiPass;

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
