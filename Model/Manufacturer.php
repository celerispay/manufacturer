<?php

/**
 * Copyright 2019 Newgen Payment Gateway Pvt. Ltd. All rights reserved.
 * Distribution of this software without explicit written consent from Newgen is
 * strictly prohibited. No part of this software must not be reverse engineered,
 * copied, reproduced or modified.
 */

namespace Boostsales\Manufacturer\Model;

use Magento\Framework\DataObject\IdentityInterface;

class Manufacturer extends \Magento\Framework\Model\AbstractModel implements IdentityInterface
{

    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;
    const CACHE_TAG = 'boostsales_manufacturer';
    protected $_cacheTag = 'boostsales_manufacturer';
    protected $_eventPrefix = 'boostsales_manufacturer';

    protected function _construct()
    {
        $this->_init('Boostsales\Manufacturer\Model\ResourceModel\Manufacturer');
    }

    public function load($id, $field = null)
    {
        return parent::load($id, $field);
    }

    public function checkIdentifier($identifier)
    {
        return $this->_getResource()->checkIdentifier($identifier);
    }

    public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getId()
    {
        return parent::getData('manufacturer_id');
    }

    public function getIdentifier()
    {
        return $this->getData('identifier');
    }

    public function getTitle()
    {
        return $this->getData('title');
    }

    public function isActive()
    {
        return $this->getData('is_active');
    }

    public function getCreatedAt()
    {
        return $this->getData('created_at');
    }

    public function getUpdatedAt()
    {
        return $this->getData('updated_at');
    }

    public function setCreatedAt($created_at)
    {
        return $this->setData('created_at', $created_at);
    }

    public function setUpdatedAt($updated_at)
    {
        return $this->setData('updated_at', $updated_at);
    }

    public function getAllLogoUrl($mfg_id,$colId)
    {
        $logoUrl = $this->_getResource()->getManufacturerUrlById($mfg_id,$colId);
        return $logoUrl;
        // return $this->getData('mfg_url_antratek_be');
    }
}
