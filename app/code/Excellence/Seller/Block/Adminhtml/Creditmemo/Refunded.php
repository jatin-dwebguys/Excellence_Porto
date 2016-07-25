<?php
namespace Excellence\Seller\Block\Adminhtml\Creditmemo;

class Refunded  extends  \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer {


    public function __construct( \Magento\Framework\Locale\CurrencyInterface $localeCurrency,
     \Magento\Store\Model\StoreManagerInterface $storeManager) {
	  $this->_storeManager = $storeManager;
	    $this->_localeCurrency = $localeCurrency;
    }

	 public function render(\Magento\Framework\DataObject $row){
	  $entity_id = parent::_getValue($row);
	 $store=  $this->_storeManager->getStore();
         $refunded=$this->_localeCurrency->getCurrency($store->getBaseCurrencyCode())->getSymbol().$entity_id;
         
         
	  return $refunded;
	 }
}
