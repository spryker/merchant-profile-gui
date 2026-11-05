<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace SprykerTest\Zed\MerchantProfileGui\Communication\Form;

use Codeception\Test\Unit;
use Spryker\Zed\Gui\Communication\Form\Type\RichTextEditorType;
use SprykerTest\Zed\MerchantProfileGui\Stub\MerchantProfileGlossaryAttributeValuesFormTypeRichTextFieldStub;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

/**
 * Auto-generated group annotations
 *
 * @group SprykerTest
 * @group Zed
 * @group MerchantProfileGui
 * @group Communication
 * @group Form
 * @group MerchantProfileGlossaryAttributeValuesFormTypeTest
 * Add your own group annotations below this line
 */
class MerchantProfileGlossaryAttributeValuesFormTypeTest extends Unit
{
    protected const array FIELD_OPTIONS = ['label' => 'Content', 'required' => false];

    public function testFieldUsesTheGuiRichTextEditorTypeWhenGuiProvidesIt(): void
    {
        // Act
        $fieldType = $this->createFormType(true)->getFieldType();

        // Assert
        $this->assertSame(RichTextEditorType::class, $fieldType);
    }

    public function testFieldOptionsConfigureTheRichTextEditorWhenGuiProvidesIt(): void
    {
        // Act
        $fieldOptions = $this->createFormType(true)->getFieldOptions(static::FIELD_OPTIONS);

        // Assert
        $this->assertSame(static::FIELD_OPTIONS, $fieldOptions);
    }

    public function testFieldFallsBackToTheSummernoteTextareaWithAnOlderGui(): void
    {
        // Arrange
        $formType = $this->createFormType(false);

        // Act
        $fieldType = $formType->getFieldType();
        $fieldOptions = $formType->getFieldOptions(static::FIELD_OPTIONS);

        // Assert
        $this->assertSame(TextareaType::class, $fieldType);
        $this->assertSame(static::FIELD_OPTIONS + ['attr' => ['class' => 'html-editor']], $fieldOptions);
    }

    public function testFieldUsesTheGuiRichTextEditorTypeWithTheInstalledGui(): void
    {
        // Act
        $fieldType = $this->createFormType(null)->getFieldType();

        // Assert
        $this->assertSame(RichTextEditorType::class, $fieldType);
    }

    protected function createFormType(?bool $isGuiRichTextEditorTypeAvailable): MerchantProfileGlossaryAttributeValuesFormTypeRichTextFieldStub
    {
        return new MerchantProfileGlossaryAttributeValuesFormTypeRichTextFieldStub($isGuiRichTextEditorTypeAvailable);
    }
}
