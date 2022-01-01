<?php

declare(strict_types=1);

/**
 * Copyright (c) 2020-2022 Andreas Möller
 *
 * For the full copyright and license information, please view
 * the LICENSE.md file that was distributed with this source code.
 *
 * @see https://github.com/ergebnis/symfony-application-template
 */

namespace App;

use Symfony\Bundle\FrameworkBundle;
use Symfony\Component\Config;
use Symfony\Component\DependencyInjection;
use Symfony\Component\HttpKernel;
use Symfony\Component\Routing;

final class Kernel extends HttpKernel\Kernel
{
    use FrameworkBundle\Kernel\MicroKernelTrait;
    private const CONFIG_EXTS = '.{php,xml,yaml,yml}';

    public function registerBundles(): iterable
    {
        $contents = require $this->getProjectDir() . '/config/bundles.php';

        foreach ($contents as $class => $envs) {
            if ($envs[$this->environment] ?? $envs['all'] ?? false) {
                yield new $class();
            }
        }
    }

    public function getProjectDir(): string
    {
        return \dirname(__DIR__);
    }

    protected function configureContainer(DependencyInjection\ContainerBuilder $containerBuilder, Config\Loader\LoaderInterface $loader): void
    {
        $containerBuilder->addResource(new Config\Resource\FileResource($this->getProjectDir() . '/config/bundles.php'));
        $containerBuilder->setParameter('container.dumper.inline_class_loader', $this->debug);
        $containerBuilder->setParameter('container.dumper.inline_factories', true);

        $confDir = $this->getProjectDir() . '/config';

        $loader->load($confDir . '/{packages}/*' . self::CONFIG_EXTS, 'glob');
        $loader->load($confDir . '/{packages}/' . $this->environment . '/*' . self::CONFIG_EXTS, 'glob');
        $loader->load($confDir . '/{services}' . self::CONFIG_EXTS, 'glob');
        $loader->load($confDir . '/{services}_' . $this->environment . self::CONFIG_EXTS, 'glob');
    }

    protected function configureRoutes(Routing\Loader\Configurator\RoutingConfigurator $routingConfigurator): void
    {
        $confDir = $this->getProjectDir() . '/config';

        $routingConfigurator->import($confDir . '/{routes}/' . $this->environment . '/*' . self::CONFIG_EXTS);
        $routingConfigurator->import($confDir . '/{routes}/*' . self::CONFIG_EXTS);
        $routingConfigurator->import($confDir . '/{routes}' . self::CONFIG_EXTS);
    }
}
