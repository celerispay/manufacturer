<?php

/**
 * Copyright 2019 Newgen Payment Gateway Pvt. Ltd. All rights reserved.
 * Distribution of this software without explicit written consent from Newgen is
 * strictly prohibited. No part of this software must not be reverse engineered,
 * copied, reproduced or modified.
 */

namespace Boostsales\Manufacturer\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;


class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * {@inheritdoc}
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        if ($context->getVersion() && version_compare($context->getVersion(), '1.6.0', '<')) {
            $this->addManufacturerUrl($setup);
        }
    }

    public function addManufacturerUrl(SchemaSetupInterface $installer)
    {
            $storesNames = [
                'be',
                'en',
                'de',
                'nl',
                'icten',
                'ictnl'
            ];

            $manufacturerUrl = $installer->getConnection();
            foreach($storesNames as $store){
                $manufacturerUrl->addColumn(
                        $installer->getTable('boostsales_manufacturer'),
                        'mfg_url_'.$store,
                        array(
                            'type' =>\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                            'length' =>255,
                            'comment' => 'MFG URL '.$store
                        ) 
                );
            }
                
            $installer->endSetup();
    }
}
