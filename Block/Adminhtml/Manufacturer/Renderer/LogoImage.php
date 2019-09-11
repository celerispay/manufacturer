<?php

/**
 * Copyright 2019 Newgen Payment Gateway Pvt. Ltd. All rights reserved.
 * Distribution of this software without explicit written consent from Newgen is
 * strictly prohibited. No part of this software must not be reverse engineered,
 * copied, reproduced or modified.
 */

namespace Boostsales\Manufacturer\Block\Adminhtml\Manufacturer\Renderer;

class LogoImage extends \Magento\Framework\Data\Form\Element\Image
{
    protected function _getUrl()
    {
        $url = 'boostsales/manufacturer/' . $this->getValue();
        return $url;
    }

}
