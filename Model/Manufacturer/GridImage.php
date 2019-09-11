<?php

/**
 * Copyright 2019 Newgen Payment Gateway Pvt. Ltd. All rights reserved.
 * Distribution of this software without explicit written consent from Newgen is
 * strictly prohibited. No part of this software must not be reverse engineered,
 * copied, reproduced or modified.
 */
namespace Boostsales\Manufacturer\Model\Manufacturer;

use Boostsales\Manufacturer\Model\Manufacturer\Media\ConfigInterface;
use Magento\Framework\App\Filesystem\DirectoryList;

class GridImage implements ConfigInterface
{
    protected $storeManager;
    protected $_processor;
    protected $_ImagesFactory;
    protected $_fileSystem;

    public function __construct(\Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Image\Factory $ImageFactory,
        \Magento\Framework\Filesystem $fileSystem
    ) {
        $this->storeManager = $storeManager;
        $this->_ImageFactory = $ImageFactory;
        $this->_fileSystem = $fileSystem;
    }

    public function getBaseMediaPathAddition()
    {
        return 'boostsales/manufacturer';
    }

    public function getBaseMediaUrlAddition()
    {
        return 'boostsales/manufacturer';
    }

    public function getBaseMediaPath()
    {
        return 'boostsales/manufacturer';
    }

    public function getBaseMediaUrl()
    {
        return $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . 'boostsales/manufacturer';
    }

    public function getBaseTmpMediaPath()
    {
        return 'tmp/' . $this->getBaseMediaPathAddition();
    }

    public function getBaseTmpMediaUrl()
    {
        return $this->storeManager->getStore()->getBaseUrl(
            \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
        ) . $this->getBaseMediaUrlAddition();
    }

    public function getMediaUrl($file)
    {
        return $this->getBaseMediaUrl() . '/' . $this->_prepareFile($file);
    }
    public function getMediaThumbnailUrl($resizePath, $file)
    {
        return $this->getBaseMediaUrl() . '/' . 'thumbnails' . '/' . $resizePath . '/' . $this->_prepareFile($file);
    }

    public function getMediaPath($file)
    {
        return $this->getBaseMediaPath() . '/' . $this->_prepareFile($file);
    }

    public function getMediaThumbnailPath($resizePath, $file)
    {
        return $this->getBaseMediaPath() . '/' . 'thumbnails' . '/' . $resizePath . '/' . $this->_prepareFile($file);
    }

    public function getTmpMediaUrl($file)
    {
        return $this->getBaseTmpMediaUrl() . '/' . $this->_prepareFile($file);
    }

    public function getTmpMediaShortUrl($file)
    {
        return 'tmp/' . $this->getBaseMediaUrlAddition() . '/' . $this->_prepareFile($file);
    }

    public function getMediaShortUrl($file)
    {
        return $this->getBaseMediaUrlAddition() . '/' . $this->_prepareFile($file);
    }

    public function getTmpMediaPath($file)
    {
        return $this->getBaseTmpMediaPath() . '/' . $this->_prepareFile($file);
    }

    protected function _prepareFile($file)
    {
        return ltrim(str_replace('\\', '/', $file), '/');
    }

    public function resizeMediaImage($fileName, $width = null, $height = null)
    {

        $dirImgpath = $this->getMediaPath($fileName);
        $checkPath = preg_replace('/\\\\/', '/', 'thumbnails');
        $resizePath = $width . 'x' . $height;
        $imageresized = $this->getMediaThumbnailPath($resizePath, $fileName);
        $mediaDirectory = $this->_fileSystem->getDirectoryRead(DirectoryList::MEDIA);
        $dirImgpath = $mediaDirectory->getAbsolutePath($dirImgpath);
        $imageresized = $mediaDirectory->getAbsolutePath($imageresized);

        if (!file_exists($imageresized) && file_exists($dirImgpath)) {
            $dirUrl = $this->getBaseMediaPath() . '/' . 'thumbnails' . '/' . $resizePath;
            $dirUrl = $mediaDirectory->getAbsolutePath($dirUrl);
            if (!file_exists($dirUrl)) {
                mkdir($dirUrl, 0777);
            }
            $this->_processor = $this->_ImageFactory->create($dirImgpath);
            $this->_processor->constrainOnly(true);
            $this->_processor->keepAspectRatio(false);
            $this->_processor->keepFrame(false);
            $this->_processor->resize($width, $height);
            $this->_processor->save($imageresized);
        }
        $resizeImageUrl = $this->getMediaThumbnailUrl($resizePath, $fileName);
        return $resizeImageUrl;
    }

}
