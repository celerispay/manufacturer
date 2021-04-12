<?php

/**
 * Copyright 2019 Newgen Payment Gateway Pvt. Ltd. All rights reserved.
 * Distribution of this software without explicit written consent from Newgen is
 * strictly prohibited. No part of this software must not be reverse engineered,
 * copied, reproduced or modified.
 */

namespace Boostsales\Manufacturer\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{

    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {

        $manufacturerTable = $setup->getTable('boostsales_manufacturer');

        if ($setup->getConnection()->isTableExists($manufacturerTable) != true) {

            $manufacturer = $setup->getConnection()
                ->newTable($manufacturerTable)
                ->addColumn(
                    'manufacturer_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                    'Manufacturer ID'
                )
                ->addColumn(
                    'title',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    ['nullable' => false, 'default' => ''],
                    'Name'
                )
                ->addColumn(
                    'identifier',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    ['nullable' => false, 'default' => ''],
                    'Identifier'
                )
                ->addColumn(
                    'manufacturer_logo',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'Image'
                )
                ->addColumn(
                    'is_active',
                    \Magento\Framework\DB\Ddl\Table::TYPE_BOOLEAN,
                    null,
                    ['nullable' => false, 'unsigned' => true],
                    'Status'
                )
                ->addColumn(
                    'created_at',
                    \Magento\Framework\DB\Ddl\Table::TYPE_DATETIME,
                    null,
                    ['nullable' => false],
                    'Created At'
                )
                ->addColumn(
                    'updated_at',
                    \Magento\Framework\DB\Ddl\Table::TYPE_DATETIME,
                    null,
                    ['nullable' => false],
                    'Updated At'
                )
                ->setComment("Manufacturer Table");
                $setup->getConnection()->createTable($manufacturer);
        }
    }
}

