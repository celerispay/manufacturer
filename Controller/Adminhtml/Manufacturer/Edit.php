<?php

/**
 * Copyright 2019 Newgen Payment Gateway Pvt. Ltd. All rights reserved.
 * Distribution of this software without explicit written consent from Newgen is
 * strictly prohibited. No part of this software must not be reverse engineered,
 * copied, reproduced or modified.
 */

namespace Boostsales\Manufacturer\Controller\Adminhtml\Manufacturer;

class Edit extends \Magento\Backend\App\Action
{

    protected $_coreRegistry = null;
    protected $resultPageFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory

    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        parent::__construct($context);
    }

    protected function _initAction()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Boostsales_Manufacturer::manufacturerlogo')
            ->addBreadcrumb(__('Boostsales'), __('Boostsales'))
            ->addBreadcrumb(__('Manage Manufacturer'), __('Manage Manufacturer'));
        return $resultPage;
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('manufacturer_id');
        $model = $this->_objectManager->create('Boostsales\Manufacturer\Model\Manufacturer');
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This manufacturer no longer exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }
        $data = $this->_objectManager->get('Magento\Backend\Model\Session')->getFormData(true);

        if (!empty($data)) {
            $model->setData($data);
        }
        $this->_coreRegistry->register('boostsales_manufacturer', $model);
        
        $resultPage = $this->_initAction();

        $resultPage->addBreadcrumb(
            $id ? __('Edit Manufacturer') : __('New Manufacturer'),
            $id ? __('Edit Manufacturer') : __('New Manufacturer')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Manufacturer'));

        return $resultPage;
    }
}
