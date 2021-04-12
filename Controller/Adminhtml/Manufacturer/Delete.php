<?php

/**
 * Copyright 2019 Newgen Payment Gateway Pvt. Ltd. All rights reserved.
 * Distribution of this software without explicit written consent from Newgen is
 * strictly prohibited. No part of this software must not be reverse engineered,
 * copied, reproduced or modified.
 */

namespace Boostsales\Manufacturer\Controller\Adminhtml\Manufacturer;

use Magento\Backend\App\Action\Context;
use Magento\Store\Model\StoreManagerInterface;

class Delete extends \Magento\Backend\App\Action
{
    protected $storeManager;
    public function __construct(Context $context, StoreManagerInterface $storeManager)
    {
        $this->storeManager = $storeManager;
        parent::__construct($context);
    }
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('manufacturer_id');
        if ($id) {
            try {
                $model = $this->_objectManager->create('Boostsales\Manufacturer\Model\Manufacturer');
                $img_path = $model->load($id)->getData();
                if(!empty($img_path['manufacturer_logo'])){
                    if(file_exists($img_path['manufacturer_logo'])){
                        unlink($this->storeManager->getStore()->getBaseMediaDir() . '/boostsales/manufacturer/' . $img_path['manufacturer_logo']);
                    }
                }
                $model->delete();
                $this->messageManager->addSuccess(__('You deleted the Manufacturer.'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['block_id' => $id]);
            }
        }
        $this->messageManager->addError(__('We can\'t find a Manufacturer to delete.'));
        return $resultRedirect->setPath('*/*/');
    }
}
