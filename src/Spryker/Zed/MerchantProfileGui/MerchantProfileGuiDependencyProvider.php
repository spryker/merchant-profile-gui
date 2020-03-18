<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantProfileGui;

use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\MerchantProfileGui\Dependency\Facade\MerchantProfileGuiToCountryFacadeBridge;
use Spryker\Zed\MerchantProfileGui\Dependency\Facade\MerchantProfileGuiToGlossaryFacadeBridge;
use Spryker\Zed\MerchantProfileGui\Dependency\Facade\MerchantProfileGuiToLocaleFacadeBridge;

/**
 * @method \Spryker\Zed\MerchantProfileGui\MerchantProfileGuiConfig getConfig()
 */
class MerchantProfileGuiDependencyProvider extends AbstractBundleDependencyProvider
{
    public const TWIG_ENVIRONMENT = 'TWIG_ENVIRONMENT';
    public const FACADE_GLOSSARY = 'FACADE_GLOSSARY';
    public const FACADE_LOCALE = 'FACADE_LOCALE';
    public const FACADE_COUNTRY = 'FACADE_COUNTRY';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideCommunicationLayerDependencies(Container $container): Container
    {
        $container = parent::provideCommunicationLayerDependencies($container);

        $container = $this->addGlossaryFacade($container);
        $container = $this->addLocaleFacade($container);
        $container = $this->addCountryFacade($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addGlossaryFacade(Container $container): Container
    {
        $container->set(static::FACADE_GLOSSARY, function (Container $container) {
            return new MerchantProfileGuiToGlossaryFacadeBridge($container->getLocator()->glossary()->facade());
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addLocaleFacade(Container $container): Container
    {
        $container->set(static::FACADE_LOCALE, function (Container $container) {
            return new MerchantProfileGuiToLocaleFacadeBridge($container->getLocator()->locale()->facade());
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCountryFacade(Container $container): Container
    {
        $container->set(static::FACADE_COUNTRY, function (Container $container) {
            return new MerchantProfileGuiToCountryFacadeBridge($container->getLocator()->country()->facade());
        });

        return $container;
    }
}
