<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 9/13/2019
 * Time: 11:20 AM
 */

namespace App\Service\OrderRegistration;

use App\Service\OrderRegistration\Interfaces\HandleCarrierInterfaceStrategy;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class RegistrationCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $resolverService = $container->findDefinition(Registration::class);

        $strategyServices = array_keys($container->findTaggedServiceIds(HandleCarrierInterfaceStrategy::SERVICE_TAG));

        foreach ($strategyServices as $strategyService) {
            $resolverService->addMethodCall('addStrategy', [new Reference($strategyService)]);
        }
    }
}
