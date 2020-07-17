<?php

namespace Boostsales\Manufacturer\Block;

class Manufacturer extends \Magento\Framework\View\Element\Template
{
    protected $_productRepo;

    protected $_productClass;

    protected $_storeManager;

    protected $urlBuilder;

    public function __construct(
        \Magento\Catalog\Model\ResourceModel\Product\Collection $productRepo,
        \Magento\Catalog\Block\Product\AbstractProduct $productClass,
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\UrlInterface $urlBuilder,
        array $data = []
    ) {
        $this->_productRepo = $productRepo;
        $this->_productClass = $productClass;
        $this->_storeManager = $storeManager;
        $this->_urlBuilder = $urlBuilder;
        parent::__construct($context, $data);
    }

    public function getManufacturer()
    {
        $product = $this->_productClass->getProduct();
        $manufacturerName = $product->getAttributeText('manufacturer');
        return $manufacturerName;
    }

    public function getManufacturerProductsLink($queryParams)
    {
        $query = [
            'q' => $queryParams,
        ];
        return $this->_urlBuilder->getUrl('catalogsearch/result/index', ['_query' => $query]);
    }

    private function getStoreInfo()
    {
        $store = $this->_storeManager->getStore();
        return $store;
    }

    public function getImagePath()
    {
        $manufacturerName = $this->getManufacturer();
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