<?php

/**
 * Copyright 2019 Newgen Payment Gateway Pvt. Ltd. All rights reserved.
 * Distribution of this software without explicit written consent from Newgen is
 * strictly prohibited. No part of this software must not be reverse engineered,
 * copied, reproduced or modified.
 */

namespace Boostsales\Manufacturer\Model\ResourceModel;

class Manufacturer extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        \Magento\Framework\Stdlib\DateTime\DateTime $dateTime
    ) {
        parent::__construct($context);
        $this->_dateTime = $dateTime;
    }

    protected function _construct()
    {
        $this->_init('boostsales_manufacturer', 'manufacturer_id');
    }
    protected function _beforeSave(\Magento\Framework\Model\AbstractModel $object)
    {
        $object->setUpdatedAt($this->_dateTime->date());
        if ($object->isObjectNew()) {
            $object->setCreatedAt($this->_dateTime->date());
        }

        if ($this->isNumericSlideshowIdentifier($object)) {
            throw new \Magento\Framework\Exception\LocalizedException(
                __('The Manufacturer identifier key cannot be made of only numbers.')
            );
        }
        return parent::_beforeSave($object);
    }

    public function load(\Magento\Framework\Model\AbstractModel $object, $value, $field = null)
    {
        if (!is_numeric($value) && is_null($field)) {
            $field = 'identifier';
        }
        return parent::load($object, $value, $field);
    }

    protected function _getLoadSelect($field, $value, $object)
    {
        $select = parent::_getLoadSelect($field, $value, $object);
        return $select;
    }

    protected function _getLoadByIdentifierSelect($identifier, $isActive = null)
    {
        $select = $this->getConnection()->select()->from(
            ['cs' => $this->getMainTable()]
        )->where(
            'cs.identifier = ?',
            $identifier
        );

        if (!is_null($isActive)) {
            $select->where('cs.status = ?', $isActive);
        }
        return $select;
    }

    protected function isNumericSlideshowIdentifier(\Magento\Framework\Model\AbstractModel $object)
    {
        return preg_match('/^[0-9]+$/', $object->getData('identifier'));
    }

    protected function isValidSlideshowIdentifier(\Magento\Framework\Model\AbstractModel $object)
    {
        return preg_match('/^[a-z0-9][a-z0-9_\/-]+(\.[a-z0-9_-]+)?$/', $object->getData('identifier'));
    }

    public function checkIdentifier($identifier)
    {
        $select = $this->_getLoadByIdentifierSelect($identifier, 1);
        $select->reset(\Magento\Framework\DB\Select::COLUMNS)->columns('cs.manufacturer_id')->limit(1);
        return $this->getConnection()->fetchOne($select);
    }

}
