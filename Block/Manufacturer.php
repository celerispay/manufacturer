<?php

namespace Boostsales\Manufacturer\Block;

class Manufacturer extends \Magento\Framework\View\Element\Template
{
    protected $_productRepo;

    protected $_productClass;

    protected $_storeManager;

    protected $urlBuilder;

    protected $_model;

    public function __construct(
        \Magento\Catalog\Model\ResourceModel\Product\Collection $productRepo,
        \Magento\Catalog\Block\Product\AbstractProduct $productClass,
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\UrlInterface $urlBuilder,
        \Boostsales\Manufacturer\Model\Manufacturer $model,
        array $data = []
    ) {
        $this->_productRepo = $productRepo;
        $this->_productClass = $productClass;
        $this->_storeManager = $storeManager;
        $this->_urlBuilder = $urlBuilder;
        $this->_model = $model;
        parent::__construct($context, $data);
    }

    public function getManufacturerName()
    {
        $manufacturerName = $this->_productClass->getProduct()->getAttributeText('manufacturer');
        return $manufacturerName;
    }

    public function getManufacturerId(){
        $attribute = $this->_productClass->getProduct()->getResource()->getAttribute('manufacturer');
        if ($attribute->usesSource()) {
            $option_id = $attribute->getSource()->getOptionId($this->getManufacturerName());
        }
        return $option_id;
    }
    
    public function getManufacturerLink()
    {   
        $mfgurls = $this->_model->getAllLogoUrl($this->getManufacturerId(),$this->getStoreCode());
        return $mfgurls[0]["mfg_url_".$this->getStoreCode()];
    }

    private function getStoreCode()
    {
        return $this->getStoreInfo()->getCode();
    }

    private function getStoreInfo()
    {
        $store = $this->_storeManager->getStore();
        return $store;
    }

    public function getImagePath()
    {
        $manufacturerName = $this->getManufacturerName();
        $mediaDir = $this->getStoreInfo()->getBaseMediaDir();
        $imageDir = $mediaDir . '/boostsales/manufacturer/' . $manufacturerName . '-logo' . '.png';
        if (file_exists($imageDir)) {
            $currentStoreMediaUrl = $this->getStoreInfo()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
            $manufacturerImage = $currentStoreMediaUrl . 'boostsales/manufacturer/' . $manufacturerName . '-logo' . '.png';
            return $manufacturerImage;
        } else {
            return;
        }
    }
}
