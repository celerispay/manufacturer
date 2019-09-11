<?php

/**
 * Copyright 2019 Newgen Payment Gateway Pvt. Ltd. All rights reserved.
 * Distribution of this software without explicit written consent from Newgen is
 * strictly prohibited. No part of this software must not be reverse engineered,
 * copied, reproduced or modified.
 */

namespace Boostsales\Manufacturer\Block\Adminhtml\Manufacturer;

class Edit extends \Magento\Backend\Block\Widget\Form\Container
{
    protected $_coreRegistry = null;

    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    protected function _construct()
    {
        $this->_objectId = 'manufacturer_id';
        $this->_blockGroup = 'Boostsales_Manufacturer';
        $this->_controller = 'adminhtml_Manufacturer';
        $this->buttonList->add(
            'saveandcontinue',
            [
                'label' => __('Save and Continue Edit'),
                'class' => 'save',
                'data_attribute' => [
                    'mage-init' => [
                        'button' => ['event' => 'saveAndContinueEdit', 'target' => '#edit_form'],
                    ],
                ],
            ],
            -100
        );
        parent::_construct();
    }

    public function getHeaderText()
    {
        $id = $this->_coreRegistry->registry('boostsales_manufacturer')->getId();
        if ($this->_coreRegistry->registry('boostsales_manufacturer')->getId()) {
            return __("Edit '%1'", $this->escapeHtml($this->_coreRegistry->registry('boostsales_manufacturer')->getTitle()));
        } else {
            return __('New Manufacturer');
        }
    }

    protected function _getSaveAndContinueUrl()
    {
        return $this->getUrl('manufacturer/*/save', ['_current' => true, 'back' => 'edit', 'active_tab' => '{{tab_id}}']);
    }

    protected function _prepareLayout()
    {
        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('slideshow_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'slideshow_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'slideshow_content');
                }
            };
        ";
        return parent::_prepareLayout();
    }
}
