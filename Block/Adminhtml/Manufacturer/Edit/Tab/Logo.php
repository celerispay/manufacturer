<?php

/**
 * Copyright 2019 Newgen Payment Gateway Pvt. Ltd. All rights reserved.
 * Distribution of this software without explicit written consent from Newgen is
 * strictly prohibited. No part of this software must not be reverse engineered,
 * copied, reproduced or modified.
 */

namespace Boostsales\Manufacturer\Block\Adminhtml\Manufacturer\Edit\Tab;

class Logo extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        array $data = []
    ) {
        parent::__construct($context, $registry, $formFactory, $data);
    }

    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry('boostsales_manufacturer');
        $form = $this->_formFactory->create();
        $fieldset = $form->addFieldset(
            'image_fieldset',
            ['legend' => __('Image'), 'class' => 'fieldset-wide']
        );
        $fieldset->addType(
            'image',
            '\Boostsales\Manufacturer\Block\Adminhtml\Manufacturer\Renderer\LogoImage'
        );
        $fieldset->addField('manufacturer_logo', 'image',
            [
                'label' => __('Image'),
                'required' => true,
                'name' => 'manufacturer_logo',
                'note' => 'Allowed Type only .png',
            ]);

        $form->setValues($model->getData());
        $this->setForm($form);
        return parent::_prepareForm();
    }

    public function getTabLabel()
    {
        return __('Logo');
    }

    public function getTabTitle()
    {
        return __('Logo');
    }

    public function canShowTab()
    {
        return true;
    }

    public function isHidden()
    {
        return false;
    }

}
