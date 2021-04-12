<?php

/**
 * Copyright 2019 Newgen Payment Gateway Pvt. Ltd. All rights reserved.
 * Distribution of this software without explicit written consent from Newgen is
 * strictly prohibited. No part of this software must not be reverse engineered,
 * copied, reproduced or modified.
 */

namespace Boostsales\Manufacturer\Controller\Adminhtml\Manufacturer;

use Magento\Framework\App\Filesystem\DirectoryList;

class Save extends \Magento\Backend\App\Action
{
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $resultRedirect = $this->resultRedirectFactory->create();

        if (!$data) {
            $this->messageManager->addError(__('This manufacturer no longer exists.'));
            $resultRedirect->setPath('*/*/');
        }

        if ($data) {
            $id = $this->getRequest()->getParam('manufacturer_id');
            $model = $this->_objectManager->create('Boostsales\Manufacturer\Model\Manufacturer')->load($id);

            if (!$model->getId() && $id) {
                $this->messageManager->addError(__('This manufacturer no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }

            if (isset($data['manufacturer_logo']['value'])) {
                $data['manufacturer_logo'] = $data['manufacturer_logo']['value'];
            }

            if (empty($data['manufacturer_id'])) {
                $values = $model->getCollection()->addFieldToFilter('title', $data['title'])->getFirstItem();
                if ($values->getId()) {
                    $this->messageManager->addWarning(__('Manufacturer already exist'));
                    return $resultRedirect->setPath('*/*/edit');
                }
            }
        }

        try {
            if (isset($_FILES['manufacturer_logo']) && !empty($_FILES['manufacturer_logo']['name'])) {

                $filename = basename($_FILES["manufacturer_logo"]["name"]);
                $extension = explode("/", $_FILES["manufacturer_logo"]["type"]);
                $name = $this->getEavAttribute($data) . "-logo" . "." . $extension[1];
                $uploader = $this->_objectManager->create(
                    \Magento\MediaStorage\Model\File\Uploader::class,
                    ['fileId' => 'manufacturer_logo']
                );
                $uploader->setAllowedExtensions(array('png'));
                $uploader->setAllowRenameFiles(false);
                $uploader->setFilesDispersion(false);
                $mediaDirectory = $this->_objectManager->get(\Magento\Framework\Filesystem::class)
                    ->getDirectoryRead(DirectoryList::MEDIA);
                $config = $this->_objectManager->get('Boostsales\Manufacturer\Model\Manufacturer\Media\Config');
                $path = $mediaDirectory->getAbsolutePath($config->getBaseMediaPath());
                $uploader->save($path, $name);
                $data['manufacturer_logo'] = $name;
            } else {
                if (isset($_FILES['manufacturer_logo']['delete']) && $_FILES['manufacturer_logo']['delete'] == 1) {
                    $data['manufacturer_logo'] = '';
                } else {
                    unset($data['manufacturer_logo']);
                }
            }

            $model->setData($data);

            $model->save();

            $this->messageManager->addSuccess(__('You saved the manufacturer.'));

            $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);

            if ($this->getRequest()->getParam('back')) {
                return $resultRedirect->setPath('*/*/edit', ['manufacturer_id' => $model->getId()]);
            }

            return $resultRedirect->setPath('*/*/');

        } catch (\Exception $e) {

            $this->messageManager->addError($e->getMessage());

            $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData($data);

            return $resultRedirect->setPath('*/*/edit', ['manufacturer_id' => $this->getRequest()->getParam('manufacturer_id')]);
        }

        return $resultRedirect->setPath('*/*/');
    }
    protected function getEavAttribute($data)
    {
        $eavAttr = $this->_objectManager->create('Magento\Eav\Model\Config');
        $manufacturer = $eavAttr->getAttribute('catalog_product', 'manufacturer');
        $allOptions = $manufacturer->getSource()->getAllOptions(true, true);
        foreach ($allOptions as $option) {
            if ($data['title'] == $option["value"]) {
                $newImageName = $option['label'];
            }
        }
        return $newImageName;
    }
}
