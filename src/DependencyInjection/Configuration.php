<?php

declare(strict_types=1);

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\CmSmsBundle\DependencyInjection;

use Endroid\CmSms\Client;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('endroid_cm_sms');

        if (method_exists($treeBuilder, 'root')) {
            $rootNode = $treeBuilder->root('endroid_cm_sms');
        } else {
            $rootNode = $treeBuilder->getRootNode();
        }

        $rootNode
            ->children()
                ->booleanNode('disable_delivery')->defaultFalse()->end()
                ->arrayNode('delivery_phone_numbers')
                    ->prototype('scalar')->end()
                ->end()
                ->scalarNode('product_token')->isRequired()->end()
                ->arrayNode('defaults')
                    ->children()
                        ->scalarNode('unicode')
                            ->validate()
                            ->ifNotInArray(Client::getUnicodeOptions())
                                ->thenInvalid('Invalid unicode mode %s, choose one from ["'.implode('", "', Client::getUnicodeOptions()).'"]')
                            ->end()
                        ->end()
                        ->scalarNode('sender')
                            ->validate()
                            ->always(function ($sender) {
                                Client::assertValidSender($sender);

                                return $sender;
                            })
                            ->end()
                        ->end()
                        ->integerNode('minimum_number_of_message_parts')->min(1)->end()
                        ->integerNode('maximum_number_of_message_parts')->end()
        ;

        return $treeBuilder;
    }
}
