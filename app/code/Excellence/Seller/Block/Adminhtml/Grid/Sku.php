<?php
namespace Excellence\Seller\Block\Adminhtml\Grid;

class Sku  extends  \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer {


    public function __construct( \Magento\Sales\Model\OrderFactory $OrderFactory,
       \Magento\Backend\Model\Auth\Session $authSession, 
       \Magento\Catalog\Model\ProductFactory $ProductFactory,
     \Magento\Store\Model\StoreManagerInterface $storeManager) {
	  $this->_storeManager = $storeManager;
	  $this->OrderFactory = $OrderFactory;
      $this->authSession = $authSession;
      $this->ProductFactory = $ProductFactory;
	    
    }

	 public function render(\Magento\Framework\DataObject $row){
  $entity_id = parent::_getValue($row);

    $order=$this->OrderFactory->create()->load($entity_id);
    $sku=array();
   $_items = $order->getAllItems();
   $email=$this->authSession->getUser()->getEmail();
   $roleName = $this->authSession->getUser()->getRole()->getRoleName();

   $product= $this->ProductFactory->create();
   foreach($_items as $item) {
      if($roleName=='Supplier'){ 
       $sellerEmail=$product->load($item->getProductId())->getAttributeText('seller_account');
        if($email == $sellerEmail){
          $sku[]=$item->getSku();

        }
      } else {
           $sku[]=$item->getSku();
      }
               
     
   }
  
  $skus=implode(' , ', $sku);
	
       return $skus;
	 }
}
