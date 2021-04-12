<?php

/**
 * Copyright 2019 Newgen Payment Gateway Pvt. Ltd. All rights reserved.
 * Distribution of this software without explicit written consent from Newgen is
 * strictly prohibited. No part of this software must not be reverse engineered,
 * copied, reproduced or modified.
 */

namespace Boostsales\Manufacturer\Block\Adminhtml\Manufacturer\Edit\Tab;

class Main extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    protected $attribute;

    protected $store;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Eav\Model\Config $attribute,
        \Magento\Store\Model\System\Store $store,
        array $data = []
    ) {
        parent::__construct($context, $registry, $formFactory, $data);
        $this->attribute = $attribute;
        $this->store = $store;
    }

    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry('boostsales_manufacturer');
        $form = $this->_formFactory->create(
            ['data' => ['id' => 'edit_form', 'action' => $this->getData('action'), 'method' => 'post']]
        );
        $form->setHtmlIdPrefix('manufacturer_main_');
        $fieldset = $form->addFieldset(
            'base_fieldset',
            ['legend' => __('General Information'), 'class' => 'fieldset-wide']
        );
        if ($model->getManufacturerId()) {
            $fieldset->addField('manufacturer_id', 'hidden', ['name' => 'manufacturer_id']);
        }
        
        $manufacturer = $this->attribute->getAttribute('catalog_product', 'manufacturer');
        $allOptions = $manufacturer->getSource()->getAllOptions(true, true);

        $fieldset->addField(
            'title', 
            'select', 
            array(
                'label' => __('Manufacturer Name'),
                'name' => 'title',
                'values' => $allOptions,
                'required' => true,
            )
        );

        $fieldset->addField(
            'identifier',
            'text',
            [
                'name' => 'identifier',
                'label' => __('Identifier'),
                'title' => __('Identifier'),
                'required' => true,
                'class' => 'validate-xml-identifier',
            ]
        );

        $fieldset->addField(
            'is_active',
            'select',
            [
                'label' => __('Status'),
                'title' => __('Status'),
                'index' => 'is_active',
                'name' => 'is_active',
                'required' => true,
                'options' => ['1' => __('Enabled'), '0' => __('Disabled')],
            ]
        );

        if (!$model->getManufacturerId()) {
            $model->setData('is_active', '1');
        }

        $form->setValues($model->getData());
        $this->setForm($form);
        return parent::_prepareForm();
    }

    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }

    public function getTabLabel()
    {
        return __('Main Content');
    }

    public function getTabTitle()
    {
        return __('Main Content');
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
