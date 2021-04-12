<?php

/**
 * Copyright 2019 Newgen Payment Gateway Pvt. Ltd. All rights reserved.
 * Distribution of this software without explicit written consent from Newgen is
 * strictly prohibited. No part of this software must not be reverse engineered,
 * copied, reproduced or modified.
 */

namespace Boostsales\Manufacturer\Block\Adminhtml\Manufacturer\Edit\Tab;

class ManufacturerUrl extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    protected $store;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Store\Model\System\Store $store,
        array $data = []
    ) {
        parent::__construct($context, $registry, $formFactory, $data);
        $this->store = $store;
    }

    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry('boostsales_manufacturer');
        $form = $this->_formFactory->create();
        $fieldset = $form->addFieldset(
            'base_fieldset',
            ['legend' => __('Manufacturer Logo Url'), 'class' => 'fieldset-wide']
        );
        $storeArray = $this->store->getStoreOptionHash(false, $attribute = 'code');
        foreach($storeArray as $store)
        {
            $fieldset->addField(
                strtolower("mfg_url_".str_replace('.','_',$store)),
                'text',
                [
                    'name' => strtolower("mfg_url_".str_replace('.','_',$store)),
                    'label' => __("Logo Url (".$store.")"),
                    'title' => __("Logo Url (".$store.")"),
                    'required' => false,
                ]
            );
        }

        $form->setValues($model->getData());
        $this->setForm($form);
        return parent::_prepareForm();
    }

    public function getTabLabel()
    {
        return __('Logo Url');
    }

    public function getTabTitle()
    {
        return __('Logo Url');
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
