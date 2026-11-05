<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace SprykerTest\Zed\MerchantProfileGui\Stub;

use Spryker\Zed\MerchantProfileGui\Communication\Form\MerchantProfileGlossary\MerchantProfileGlossaryAttributeValuesFormType;

/**
 * Exposes the rich-text field type and options, with the Gui `RichTextEditorType` availability forced or,
 * with `null`, read from the real `class_exists()` check.
 */
class MerchantProfileGlossaryAttributeValuesFormTypeRichTextFieldStub extends MerchantProfileGlossaryAttributeValuesFormType
{
    public function __construct(protected ?bool $isGuiRichTextEditorTypeAvailableOverride)
    {
    }

    public function getFieldType(): string
    {
        return $this->getRichTextFieldType();
    }

    /**
     * @param array<string, mixed> $options
     *
     * @return array<string, mixed>
     */
    public function getFieldOptions(array $options): array
    {
        return $this->getRichTextFieldOptions($options);
    }

    protected function isGuiRichTextEditorTypeAvailable(): bool
    {
        return $this->isGuiRichTextEditorTypeAvailableOverride ?? parent::isGuiRichTextEditorTypeAvailable();
    }
}
