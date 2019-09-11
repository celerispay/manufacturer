<?php

/**
 * Copyright 2019 Newgen Payment Gateway Pvt. Ltd. All rights reserved.
 * Distribution of this software without explicit written consent from Newgen is
 * strictly prohibited. No part of this software must not be reverse engineered,
 * copied, reproduced or modified.
 */

namespace Boostsales\Manufacturer\Block\Adminhtml\Manufacturer\Edit;

class Tabs extends \Magento\Backend\Block\Widget\Tabs
{

    public function _construct()
    {
        parent::_construct();
        $this->setId('manufacturer_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Manufacturer'));
    }
}
