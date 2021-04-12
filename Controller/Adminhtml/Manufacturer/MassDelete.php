<?php

/**
 * Copyright 2019 Newgen Payment Gateway Pvt. Ltd. All rights reserved.
 * Distribution of this software without explicit written consent from Newgen is
 * strictly prohibited. No part of this software must not be reverse engineered,
 * copied, reproduced or modified.
 */

namespace Boostsales\Manufacturer\Controller\Adminhtml\Manufacturer;

use Boostsales\Manufacturer\Model\ResourceModel\Manufacturer\CollectionFactory;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\Component\MassAction\Filter;

class MassDelete extends \Magento\Backend\App\Action
{
    protected $filter;
    protected $collectionFactory;
    protected $storeManager;

    public function __construct(Context $context, Filter $filter, CollectionFactory $collectionFactory, StoreManagerInterface $storeManager)
    {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->storeManager = $storeManager;
        parent::__construct($context);
    }

    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $logo_data = $collection->getData();
        foreach ($logo_data as $key) {
            if(!empty($key['manufacturer_logo'])){
                unlink($this->storeManager->getStore()->getBaseMediaDir() . '/boostsales/manufacturer/' . $key['manufacturer_logo']);
            }
        }
        $collectionSize = $collection->getSize();

        foreach ($collection as $block) {
            $block->delete();
        }
        $this->messageManager->addSuccess(__('A total of %1 record(s) have been deleted.', $collectionSize));
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}
