<?php

declare(strict_types=1);

namespace TictactoeApi\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * OpenAPIServerApiPass
 *
 * Compiler pass to register API handlers.
 * Auto-generated from OpenAPI specification.
 */
class OpenAPIServerApiPass implements CompilerPassInterface
{
    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container) {
        // always first check if the primary service is defined
        if (!$container->has('open_api_server.api.api_server')) {
            return;
        }

        $definition = $container->findDefinition('open_api_server.api.api_server');

        // find all service IDs with the open_api_server.api tag
        $taggedServices = $container->findTaggedServiceIds('open_api_server.api');

        foreach ($taggedServices as $id => $tags) {
            foreach ($tags as $tag) {
                // add the transport service to the ChainTransport service
                $definition->addMethodCall('addApiHandler', [$tag['api'], new Reference($id)]);
            }
        }
    }
}
