<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantProfileGui\Communication\Form\DataProvider;

use ArrayObject;
use Generated\Shared\Transfer\LocaleTransfer;
use Generated\Shared\Transfer\MerchantProfileGlossaryAttributeValuesTransfer;
use Generated\Shared\Transfer\MerchantProfileLocalizedGlossaryAttributesTransfer;
use Generated\Shared\Transfer\MerchantProfileTransfer;
use Spryker\Zed\MerchantProfileGui\Communication\Form\MerchantProfileFormType;
use Spryker\Zed\MerchantProfileGui\Dependency\Facade\MerchantProfileGuiToGlossaryFacadeInterface;
use Spryker\Zed\MerchantProfileGui\Dependency\Facade\MerchantProfileGuiToLocaleFacadeInterface;
use Spryker\Zed\MerchantProfileGui\MerchantProfileGuiConfig;

class MerchantProfileFormDataProvider
{
    /**
     * @var \Spryker\Zed\MerchantProfileGui\MerchantProfileGuiConfig
     */
    protected $config;

    /**
     * @var \Spryker\Zed\MerchantProfileGui\Dependency\Facade\MerchantProfileGuiToGlossaryFacadeInterface
     */
    protected $glossaryFacade;

    /**
     * @var \Spryker\Zed\MerchantProfileGui\Dependency\Facade\MerchantProfileGuiToLocaleFacadeInterface
     */
    protected $localeFacade;

    public function __construct(
        MerchantProfileGuiConfig $config,
        MerchantProfileGuiToGlossaryFacadeInterface $glossaryFacade,
        MerchantProfileGuiToLocaleFacadeInterface $localeFacade
    ) {
        $this->config = $config;
        $this->glossaryFacade = $glossaryFacade;
        $this->localeFacade = $localeFacade;
    }

    /**
     * @return array<string, mixed>
     */
    public function getOptions(): array
    {
        return [
            'data_class' => MerchantProfileTransfer::class,
            'label' => false,
            MerchantProfileFormType::SALUTATION_CHOICES_OPTION => $this->config->getSalutationChoices(),
        ];
    }

    public function getData(?MerchantProfileTransfer $merchantProfileTransfer): MerchantProfileTransfer
    {
        if ($merchantProfileTransfer === null) {
            $merchantProfileTransfer = new MerchantProfileTransfer();
        }

        $merchantProfileTransfer = $this->addLocalizedGlossaryAttributes($merchantProfileTransfer);

        return $merchantProfileTransfer;
    }

    protected function addLocalizedGlossaryAttributes(MerchantProfileTransfer $merchantProfileTransfer): MerchantProfileTransfer
    {
        $merchantProfileGlossaryAttributeValues = new ArrayObject();
        $localeTransfers = $this->localeFacade->getLocaleCollection();
        $glossaryKeysIndexedByFieldName = $this->extractGlossaryKeysIndexedByFieldName($merchantProfileTransfer);
        $activeTranslationValues = $this->getActiveTranslationValuesIndexedByGlossaryKeyAndIdLocale(
            array_values(array_unique($glossaryKeysIndexedByFieldName)),
            array_values($localeTransfers),
        );

        foreach ($localeTransfers as $localeTransfer) {
            $merchantProfileGlossaryAttributeValues->append(
                $this->addGlossaryAttributesByLocale($glossaryKeysIndexedByFieldName, $localeTransfer, $activeTranslationValues),
            );
        }

        $merchantProfileTransfer->setMerchantProfileLocalizedGlossaryAttributes($merchantProfileGlossaryAttributeValues);

        return $merchantProfileTransfer;
    }

    /**
     * @param array<string, string> $glossaryKeysIndexedByFieldName
     * @param \Generated\Shared\Transfer\LocaleTransfer $localeTransfer
     * @param array<string, array<int, string|null>> $activeTranslationValues
     *
     * @return \Generated\Shared\Transfer\MerchantProfileLocalizedGlossaryAttributesTransfer
     */
    protected function addGlossaryAttributesByLocale(
        array $glossaryKeysIndexedByFieldName,
        LocaleTransfer $localeTransfer,
        array $activeTranslationValues
    ): MerchantProfileLocalizedGlossaryAttributesTransfer {
        $merchantProfileLocalizedGlossaryAttributesTransfer = new MerchantProfileLocalizedGlossaryAttributesTransfer();
        $merchantProfileLocalizedGlossaryAttributesTransfer->setLocale($localeTransfer);
        $merchantProfileLocalizedGlossaryAttributesTransfer->setMerchantProfileGlossaryAttributeValues(
            $this->addGlossaryAttributeTranslations($glossaryKeysIndexedByFieldName, $localeTransfer, $activeTranslationValues),
        );

        return $merchantProfileLocalizedGlossaryAttributesTransfer;
    }

    /**
     * @param array<string, string> $glossaryKeysIndexedByFieldName
     * @param \Generated\Shared\Transfer\LocaleTransfer $localeTransfer
     * @param array<string, array<int, string|null>> $activeTranslationValues
     *
     * @return \Generated\Shared\Transfer\MerchantProfileGlossaryAttributeValuesTransfer
     */
    protected function addGlossaryAttributeTranslations(
        array $glossaryKeysIndexedByFieldName,
        LocaleTransfer $localeTransfer,
        array $activeTranslationValues
    ): MerchantProfileGlossaryAttributeValuesTransfer {
        $merchantProfileGlossaryAttributeValuesData = [];
        foreach ($glossaryKeysIndexedByFieldName as $fieldName => $glossaryKey) {
            $merchantProfileGlossaryAttributeValuesData[$fieldName] = $activeTranslationValues[$glossaryKey][$localeTransfer->getIdLocaleOrFail()] ?? null;
        }

        return (new MerchantProfileGlossaryAttributeValuesTransfer())->fromArray($merchantProfileGlossaryAttributeValuesData);
    }

    /**
     * @return array<string, string>
     */
    protected function extractGlossaryKeysIndexedByFieldName(MerchantProfileTransfer $merchantProfileTransfer): array
    {
        $merchantProfileData = $merchantProfileTransfer->toArray(true, true);
        $glossaryKeysIndexedByFieldName = [];
        foreach (array_keys((new MerchantProfileGlossaryAttributeValuesTransfer())->toArray(true, true)) as $fieldName) {
            $glossaryKey = $merchantProfileData[$fieldName] ?? null;
            if (!$glossaryKey) {
                continue;
            }

            $glossaryKeysIndexedByFieldName[$fieldName] = $glossaryKey;
        }

        return $glossaryKeysIndexedByFieldName;
    }

    /**
     * @param array<string> $glossaryKeys
     * @param array<\Generated\Shared\Transfer\LocaleTransfer> $localeTransfers
     *
     * @return array<string, array<int, string|null>>
     */
    protected function getActiveTranslationValuesIndexedByGlossaryKeyAndIdLocale(array $glossaryKeys, array $localeTransfers): array
    {
        if ($glossaryKeys === []) {
            return [];
        }

        $activeTranslationValues = [];
        foreach ($this->glossaryFacade->getTranslationsByGlossaryKeysAndLocaleTransfers($glossaryKeys, $localeTransfers) as $translationTransfer) {
            if (!$translationTransfer->getIsActive()) {
                continue;
            }

            $activeTranslationValues[$translationTransfer->getGlossaryKeyOrFail()->getKeyOrFail()][$translationTransfer->getFkLocaleOrFail()] = $translationTransfer->getValue();
        }

        return $activeTranslationValues;
    }
}
