<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantProfileGui\Communication;

use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;
use Spryker\Zed\MerchantProfileGui\Communication\Form\DataProvider\MerchantProfileAddressFormDataProvider;
use Spryker\Zed\MerchantProfileGui\Communication\Form\DataProvider\MerchantProfileFormDataProvider;
use Spryker\Zed\MerchantProfileGui\Communication\Form\MerchantProfileFormType;
use Spryker\Zed\MerchantProfileGui\Dependency\Facade\MerchantProfileGuiToCountryFacadeInterface;
use Spryker\Zed\MerchantProfileGui\Dependency\Facade\MerchantProfileGuiToGlossaryFacadeInterface;
use Spryker\Zed\MerchantProfileGui\Dependency\Facade\MerchantProfileGuiToLocaleFacadeInterface;
use Spryker\Zed\MerchantProfileGui\MerchantProfileGuiDependencyProvider;
use Symfony\Component\Form\FormTypeInterface;

/**
 * @method \Spryker\Zed\MerchantProfileGui\MerchantProfileGuiConfig getConfig()
 */
class MerchantProfileGuiCommunicationFactory extends AbstractCommunicationFactory
{
    public function createMerchantProfileForm(): FormTypeInterface
    {
        return new MerchantProfileFormType();
    }

    public function createMerchantProfileFormDataProvider(): MerchantProfileFormDataProvider
    {
        return new MerchantProfileFormDataProvider(
            $this->getConfig(),
            $this->getGlossaryFacade(),
            $this->getLocaleFacade(),
        );
    }

    public function createMerchantProfileAddressFormDataProvider(): MerchantProfileAddressFormDataProvider
    {
        return new MerchantProfileAddressFormDataProvider(
            $this->getCountryFacade(),
        );
    }

    public function getGlossaryFacade(): MerchantProfileGuiToGlossaryFacadeInterface
    {
        return $this->getProvidedDependency(MerchantProfileGuiDependencyProvider::FACADE_GLOSSARY);
    }

    public function getLocaleFacade(): MerchantProfileGuiToLocaleFacadeInterface
    {
        return $this->getProvidedDependency(MerchantProfileGuiDependencyProvider::FACADE_LOCALE);
    }

    public function getCountryFacade(): MerchantProfileGuiToCountryFacadeInterface
    {
        return $this->getProvidedDependency(MerchantProfileGuiDependencyProvider::FACADE_COUNTRY);
    }
}
