<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantProfileGui\Communication;

use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;
use Spryker\Zed\MerchantProfileGui\Communication\ButtonCreator\MerchantProfileChangeStatusButtonCreator;
use Spryker\Zed\MerchantProfileGui\Communication\ButtonCreator\MerchantProfileChangeStatusButtonCreatorInterface;
use Spryker\Zed\MerchantProfileGui\Communication\Form\DataProvider\MerchantProfileFormDataProvider;
use Spryker\Zed\MerchantProfileGui\Communication\Form\MerchantProfileFormType;
use Spryker\Zed\MerchantProfileGui\Communication\LabelCreator\MerchantProfileActiveLabelCreator;
use Spryker\Zed\MerchantProfileGui\Communication\LabelCreator\MerchantProfileActiveLabelCreatorInterface;
use Spryker\Zed\MerchantProfileGui\Dependency\Facade\MerchantProfileGuiToGlossaryFacadeInterface;
use Spryker\Zed\MerchantProfileGui\Dependency\Facade\MerchantProfileGuiToLocaleFacadeInterface;
use Spryker\Zed\MerchantProfileGui\Dependency\Facade\MerchantProfileGuiToMerchantProfileFacadeInterface;
use Spryker\Zed\MerchantProfileGui\MerchantProfileGuiDependencyProvider;
use Symfony\Component\Form\FormTypeInterface;
use Twig\Environment;

/**
 * @method \Spryker\Zed\MerchantProfileGui\MerchantProfileGuiConfig getConfig()
 */
class MerchantProfileGuiCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @return \Symfony\Component\Form\FormTypeInterface
     */
    public function createMerchantProfileForm(): FormTypeInterface
    {
        return new MerchantProfileFormType();
    }

    /**
     * @return \Spryker\Zed\MerchantProfileGui\Communication\Form\DataProvider\MerchantProfileFormDataProvider
     */
    public function createMerchantProfileFormDataProvider(): MerchantProfileFormDataProvider
    {
        return new MerchantProfileFormDataProvider(
            $this->getConfig(),
            $this->getGlossaryFacade(),
            $this->getLocaleFacade()
        );
    }

    /**
     * @return \Spryker\Zed\MerchantProfileGui\Communication\ButtonCreator\MerchantProfileChangeStatusButtonCreatorInterface
     */
    public function createMerchantProfileChangeStatusButtonCreator(): MerchantProfileChangeStatusButtonCreatorInterface
    {
        return new MerchantProfileChangeStatusButtonCreator(
            $this->getMerchantProfileFacade()
        );
    }

    /**
     * @return \Spryker\Zed\MerchantProfileGui\Communication\LabelCreator\MerchantProfileActiveLabelCreatorInterface
     */
    public function createMerchantProfileActiveLabelCreator(): MerchantProfileActiveLabelCreatorInterface
    {
        return new MerchantProfileActiveLabelCreator(
            $this->getMerchantProfileFacade(),
            $this->getTwigEnvironment()
        );
    }

    /**
     * @return \Twig\Environment
     */
    public function getTwigEnvironment(): Environment
    {
        return $this->getProvidedDependency(MerchantProfileGuiDependencyProvider::TWIG_ENVIRONMENT);
    }

    /**
     * @return \Spryker\Zed\MerchantProfileGui\Dependency\Facade\MerchantProfileGuiToMerchantProfileFacadeInterface
     */
    public function getMerchantProfileFacade(): MerchantProfileGuiToMerchantProfileFacadeInterface
    {
        return $this->getProvidedDependency(MerchantProfileGuiDependencyProvider::FACADE_MERCHANT_PROFILE);
    }

    /**
     * @return \Spryker\Zed\MerchantProfileGui\Dependency\Facade\MerchantProfileGuiToGlossaryFacadeInterface
     */
    public function getGlossaryFacade(): MerchantProfileGuiToGlossaryFacadeInterface
    {
        return $this->getProvidedDependency(MerchantProfileGuiDependencyProvider::FACADE_GLOSSARY);
    }

    /**
     * @return \Spryker\Zed\MerchantProfileGui\Dependency\Facade\MerchantProfileGuiToLocaleFacadeInterface
     */
    public function getLocaleFacade(): MerchantProfileGuiToLocaleFacadeInterface
    {
        return $this->getProvidedDependency(MerchantProfileGuiDependencyProvider::FACADE_LOCALE);
    }
}
