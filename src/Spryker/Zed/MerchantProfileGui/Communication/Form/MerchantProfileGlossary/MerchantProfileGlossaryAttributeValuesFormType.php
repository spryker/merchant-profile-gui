<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantProfileGui\Communication\Form\MerchantProfileGlossary;

use Spryker\Zed\Gui\Communication\Form\Type\RichTextEditorType;
use Spryker\Zed\Kernel\Communication\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * @method \Spryker\Zed\MerchantProfileGui\MerchantProfileGuiConfig getConfig()
 * @method \Spryker\Zed\MerchantProfileGui\Communication\MerchantProfileGuiCommunicationFactory getFactory()
 */
class MerchantProfileGlossaryAttributeValuesFormType extends AbstractType
{
    /**
     * @var string
     */
    protected const FIELD_DESCRIPTION_GLOSSARY = 'descriptionGlossaryKey';

    /**
     * @var string
     */
    protected const FIELD_BANNER_URL_GLOSSARY = 'bannerUrlGlossaryKey';

    /**
     * @var string
     */
    protected const FIELD_DELIVERY_TIME_GLOSSARY = 'deliveryTimeGlossaryKey';

    /**
     * @var string
     */
    protected const FIELD_TERMS_CONDITIONS_GLOSSARY = 'termsConditionsGlossaryKey';

    /**
     * @var string
     */
    protected const FIELD_CANCELLATION_POLICY_GLOSSARY = 'cancellationPolicyGlossaryKey';

    /**
     * @var string
     */
    protected const FIELD_IMPRINT_GLOSSARY = 'imprintGlossaryKey';

    /**
     * @var string
     */
    protected const FIELD_DATA_PRIVACY_GLOSSARY = 'dataPrivacyGlossaryKey';

    /**
     * @var string
     */
    protected const LABEL_DESCRIPTION_GLOSSARY = 'Description';

    /**
     * @var string
     */
    protected const LABEL_BANNER_URL_GLOSSARY = 'Banner URL';

    /**
     * @var string
     */
    protected const LABEL_DELIVERY_TIME_GLOSSARY = 'Average Delivery Time';

    /**
     * @var string
     */
    protected const LABEL_TERMS_CONDITIONS_GLOSSARY = 'Terms and Conditions';

    /**
     * @var string
     */
    protected const LABEL_CANCELLATION_POLICY_GLOSSARY = 'Cancellation Policy';

    /**
     * @var string
     */
    protected const LABEL_IMPRINT_GLOSSARY = 'Imprint';

    /**
     * @var string
     */
    protected const LABEL_DATA_PRIVACY_GLOSSARY = 'Data Privacy';

    protected const string LEGACY_HTML_EDITOR_CLASS = 'html-editor';

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array<string, mixed> $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->addDescriptionGlossaryKeyField($builder)
            ->addBannerUrlGlossaryKeyField($builder)
            ->addDeliveryTimeGlossaryKeyField($builder)
            ->addTermsConditionsGlossaryKeyField($builder)
            ->addCancellationPolicyGlossaryKeyField($builder)
            ->addImprintGlossaryKeyField($builder)
            ->addDataPrivacyGlossaryKeyField($builder);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addDescriptionGlossaryKeyField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_DESCRIPTION_GLOSSARY, TextareaType::class, [
            'label' => static::LABEL_DESCRIPTION_GLOSSARY,
            'required' => false,
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addBannerUrlGlossaryKeyField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_BANNER_URL_GLOSSARY, TextType::class, [
            'label' => static::LABEL_BANNER_URL_GLOSSARY,
            'required' => false,
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addDeliveryTimeGlossaryKeyField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_DELIVERY_TIME_GLOSSARY, TextType::class, [
            'label' => static::LABEL_DELIVERY_TIME_GLOSSARY,
            'required' => false,
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addTermsConditionsGlossaryKeyField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_TERMS_CONDITIONS_GLOSSARY, $this->getRichTextFieldType(), $this->getRichTextFieldOptions([
            'label' => static::LABEL_TERMS_CONDITIONS_GLOSSARY,
            'required' => false,
            'sanitize_xss' => true,
            'allowed_attributes' => ['style'],
            'allowed_html_tags' => ['iframe'],
        ]));

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addCancellationPolicyGlossaryKeyField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_CANCELLATION_POLICY_GLOSSARY, $this->getRichTextFieldType(), $this->getRichTextFieldOptions([
            'label' => static::LABEL_CANCELLATION_POLICY_GLOSSARY,
            'required' => false,
            'sanitize_xss' => true,
            'allowed_attributes' => ['style'],
            'allowed_html_tags' => ['iframe'],
        ]));

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addImprintGlossaryKeyField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_IMPRINT_GLOSSARY, $this->getRichTextFieldType(), $this->getRichTextFieldOptions([
            'label' => static::LABEL_IMPRINT_GLOSSARY,
            'required' => false,
            'sanitize_xss' => true,
            'allowed_attributes' => ['style'],
            'allowed_html_tags' => ['iframe'],
        ]));

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addDataPrivacyGlossaryKeyField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_DATA_PRIVACY_GLOSSARY, $this->getRichTextFieldType(), $this->getRichTextFieldOptions([
            'label' => static::LABEL_DATA_PRIVACY_GLOSSARY,
            'required' => false,
            'sanitize_xss' => true,
            'allowed_attributes' => ['style'],
            'allowed_html_tags' => ['iframe'],
        ]));

        return $this;
    }

    /**
     * @phpstan-return class-string<\Symfony\Component\Form\FormTypeInterface>
     */
    protected function getRichTextFieldType(): string
    {
        if ($this->isGuiRichTextEditorTypeAvailable()) {
            return RichTextEditorType::class;
        }

        return TextareaType::class;
    }

    /**
     * @param array<string, mixed> $options
     *
     * @return array<string, mixed>
     */
    protected function getRichTextFieldOptions(array $options): array
    {
        if ($this->isGuiRichTextEditorTypeAvailable()) {
            return $options;
        }

        return $options + [
            'attr' => [
                'class' => static::LEGACY_HTML_EDITOR_CLASS,
            ],
        ];
    }

    protected function isGuiRichTextEditorTypeAvailable(): bool
    {
        return class_exists(RichTextEditorType::class);
    }
}
