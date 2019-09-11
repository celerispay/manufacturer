<?php

/**
 * Copyright 2019 Newgen Payment Gateway Pvt. Ltd. All rights reserved.
 * Distribution of this software without explicit written consent from Newgen is
 * strictly prohibited. No part of this software must not be reverse engineered,
 * copied, reproduced or modified.
 */

namespace Boostsales\Manufacturer\Model\ResourceModel\Manufacturer;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'manufacturer_id';
    protected $_previewFlag;

    public function __construct(
        \Magento\Framework\Data\Collection\EntityFactoryInterface $entityFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        \Magento\Framework\DB\Adapter\AdapterInterface $connection = null,
        \Magento\Framework\Model\ResourceModel\Db\AbstractDb $resource = null
    ) {

        $this->_init('Boostsales\Manufacturer\Model\Manufacturer', 'Boostsales\Manufacturer\Model\ResourceModel\Manufacturer');
        $this->_map['fields']['manufacturer_id'] = 'main_table.manufacturer_id';
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $connection, $resource);
    }

    public function toOptionIdArray()
    {
        $res = [];
        $existingIdentifiers = [];
        foreach ($this as $item) {
            $manufacturer_id = $item->getData('manufacturer_id');
            $data['value'] = $manufacturer_id;
            $data['label'] = $item->getData('title');

            if (in_array($manufacturer_id, $existingIdentifiers)) {
                $data['value'] .= '|' . $item->getData('manufacturer_id');
            } else {
                $existingIdentifiers[] = $manufacturer_id;
            }
            $res[] = $data;
        }
        return $res;
    }

    public function addFieldToFilter($field, $condition = null)
    {
        return parent::addFieldToFilter($field, $condition);
    }

    public function getSelectCountSql()
    {
        $countSelect = parent::getSelectCountSql();
        $countSelect->reset(\Magento\Framework\DB\Select::GROUP);

        return $countSelect;
    }
}
