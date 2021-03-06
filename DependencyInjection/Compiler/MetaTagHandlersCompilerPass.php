<?php

namespace Netgen\Bundle\OpenGraphBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use LogicException;

class MetaTagHandlersCompilerPass implements CompilerPassInterface
{
    /**
     * Adds all registered meta tag handlers to the registry
     *
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    public function process( ContainerBuilder $container )
    {
        $metaTagHandlers = $container->findTaggedServiceIds( 'netgen_open_graph.meta_tag_handler' );
        if ( !empty( $metaTagHandlers ) && $container->hasDefinition( 'netgen_open_graph.handler_registry' ) )
        {
            $handlerRegistry = $container->getDefinition( 'netgen_open_graph.handler_registry' );
            foreach ( $metaTagHandlers as $serviceId => $metaTagHandler )
            {
                if ( !isset( $metaTagHandler[0]['alias'] ) )
                {
                    throw new LogicException(
                        'netgen_open_graph.meta_tag_handler service tag needs an "alias" attribute to identify the handler. None given.'
                    );
                }
                $handlerRegistry->addMethodCall(
                    'addHandler',
                    array(
                        $metaTagHandler[0]['alias'],
                        new Reference( $serviceId )
                    )
                );
            }
        }
    }
}
