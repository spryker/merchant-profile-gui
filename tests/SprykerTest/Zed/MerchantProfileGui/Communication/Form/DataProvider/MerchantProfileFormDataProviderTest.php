<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace SprykerTest\Zed\MerchantProfileGui\Communication\Form\DataProvider;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\GlossaryKeyTransfer;
use Generated\Shared\Transfer\LocaleTransfer;
use Generated\Shared\Transfer\MerchantProfileTransfer;
use Generated\Shared\Transfer\TranslationTransfer;
use Spryker\Zed\MerchantProfileGui\Communication\Form\DataProvider\MerchantProfileFormDataProvider;
use Spryker\Zed\MerchantProfileGui\Dependency\Facade\MerchantProfileGuiToGlossaryFacadeInterface;
use Spryker\Zed\MerchantProfileGui\Dependency\Facade\MerchantProfileGuiToLocaleFacadeInterface;
use Spryker\Zed\MerchantProfileGui\MerchantProfileGuiConfig;

/**
 * Auto-generated group annotations
 *
 * @group SprykerTest
 * @group Zed
 * @group MerchantProfileGui
 * @group Communication
 * @group Form
 * @group DataProvider
 * @group MerchantProfileFormDataProviderTest
 * Add your own group annotations below this line
 */
class MerchantProfileFormDataProviderTest extends Unit
{
    protected const int ID_LOCALE_DE = 46;

    protected const int ID_LOCALE_EN = 66;

    protected const string DESCRIPTION_GLOSSARY_KEY = 'merchant.description_glossary_key.7';

    protected const string IMPRINT_GLOSSARY_KEY = 'merchant.imprint_glossary_key.7';

    protected const string DESCRIPTION_DE = 'Beschreibung';

    protected const string DESCRIPTION_EN = 'Description';

    protected const string IMPRINT_EN = 'Imprint';

    /**
     * @var \SprykerTest\Zed\MerchantProfileGui\MerchantProfileGuiCommunicationTester
     */
    protected $tester;

    public function testGetDataLoadsAllGlossaryTranslationsWithOneCallAndSkipsInactiveOnes(): void
    {
        // Arrange
        $localeTransferDe = (new LocaleTransfer())->setIdLocale(static::ID_LOCALE_DE)->setLocaleName('de_DE');
        $localeTransferEn = (new LocaleTransfer())->setIdLocale(static::ID_LOCALE_EN)->setLocaleName('en_US');
        $merchantProfileTransfer = (new MerchantProfileTransfer())
            ->setDescriptionGlossaryKey(static::DESCRIPTION_GLOSSARY_KEY)
            ->setImprintGlossaryKey(static::IMPRINT_GLOSSARY_KEY);

        $localeFacadeMock = $this->createMock(MerchantProfileGuiToLocaleFacadeInterface::class);
        $localeFacadeMock->method('getLocaleCollection')->willReturn(['de_DE' => $localeTransferDe, 'en_US' => $localeTransferEn]);

        $glossaryFacadeMock = $this->createMock(MerchantProfileGuiToGlossaryFacadeInterface::class);

        // Expect
        $glossaryFacadeMock->expects($this->never())->method('hasTranslation');
        $glossaryFacadeMock->expects($this->never())->method('getTranslation');
        $glossaryFacadeMock->expects($this->once())
            ->method('getTranslationsByGlossaryKeysAndLocaleTransfers')
            ->with(
                $this->equalTo([static::DESCRIPTION_GLOSSARY_KEY, static::IMPRINT_GLOSSARY_KEY]),
                $this->equalTo([$localeTransferDe, $localeTransferEn]),
            )
            ->willReturn([
                $this->createTranslationTransfer(static::DESCRIPTION_GLOSSARY_KEY, static::ID_LOCALE_DE, static::DESCRIPTION_DE, true),
                $this->createTranslationTransfer(static::DESCRIPTION_GLOSSARY_KEY, static::ID_LOCALE_EN, static::DESCRIPTION_EN, true),
                $this->createTranslationTransfer(static::IMPRINT_GLOSSARY_KEY, static::ID_LOCALE_EN, static::IMPRINT_EN, false),
            ]);

        // Act
        $merchantProfileTransfer = (new MerchantProfileFormDataProvider(new MerchantProfileGuiConfig(), $glossaryFacadeMock, $localeFacadeMock))
            ->getData($merchantProfileTransfer);

        // Assert
        $localizedGlossaryAttributesTransfers = $merchantProfileTransfer->getMerchantProfileLocalizedGlossaryAttributes();
        $this->assertCount(2, $localizedGlossaryAttributesTransfers);

        $glossaryAttributeValuesTransferDe = $localizedGlossaryAttributesTransfers->offsetGet(0)->getMerchantProfileGlossaryAttributeValuesOrFail();
        $this->assertSame($localeTransferDe, $localizedGlossaryAttributesTransfers->offsetGet(0)->getLocale());
        $this->assertSame(static::DESCRIPTION_DE, $glossaryAttributeValuesTransferDe->getDescriptionGlossaryKey());
        $this->assertNull($glossaryAttributeValuesTransferDe->getImprintGlossaryKey());

        $glossaryAttributeValuesTransferEn = $localizedGlossaryAttributesTransfers->offsetGet(1)->getMerchantProfileGlossaryAttributeValuesOrFail();
        $this->assertSame($localeTransferEn, $localizedGlossaryAttributesTransfers->offsetGet(1)->getLocale());
        $this->assertSame(static::DESCRIPTION_EN, $glossaryAttributeValuesTransferEn->getDescriptionGlossaryKey());
        $this->assertNull($glossaryAttributeValuesTransferEn->getImprintGlossaryKey());
    }

    public function testGetDataSkipsGlossaryLookupForNewMerchantProfile(): void
    {
        // Arrange
        $localeFacadeMock = $this->createMock(MerchantProfileGuiToLocaleFacadeInterface::class);
        $localeFacadeMock->method('getLocaleCollection')->willReturn(['en_US' => (new LocaleTransfer())->setIdLocale(static::ID_LOCALE_EN)]);
        $glossaryFacadeMock = $this->createMock(MerchantProfileGuiToGlossaryFacadeInterface::class);

        // Expect
        $glossaryFacadeMock->expects($this->never())->method('getTranslationsByGlossaryKeysAndLocaleTransfers');
        $glossaryFacadeMock->expects($this->never())->method('hasTranslation');

        // Act
        $merchantProfileTransfer = (new MerchantProfileFormDataProvider(new MerchantProfileGuiConfig(), $glossaryFacadeMock, $localeFacadeMock))
            ->getData(null);

        // Assert
        $this->assertCount(1, $merchantProfileTransfer->getMerchantProfileLocalizedGlossaryAttributes());
        $this->assertNull(
            $merchantProfileTransfer->getMerchantProfileLocalizedGlossaryAttributes()->offsetGet(0)->getMerchantProfileGlossaryAttributeValuesOrFail()->getDescriptionGlossaryKey(),
        );
    }

    protected function createTranslationTransfer(string $glossaryKey, int $idLocale, string $value, bool $isActive): TranslationTransfer
    {
        return (new TranslationTransfer())
            ->setGlossaryKey((new GlossaryKeyTransfer())->setKey($glossaryKey))
            ->setFkLocale($idLocale)
            ->setValue($value)
            ->setIsActive($isActive);
    }
}
