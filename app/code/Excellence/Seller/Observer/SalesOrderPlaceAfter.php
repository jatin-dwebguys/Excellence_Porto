<?php
namespace Excellence\Seller\Observer;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
 
class SalesOrderPlaceAfter implements ObserverInterface
{
    
    public function __construct(
     \Magento\Catalog\Model\ProductFactory $productFactory,
     \Excellence\Seller\Model\OrderFactory $orderSeller 
     ) {
      $this->_productFactory = $productFactory;
      $this->orderSeller = $orderSeller;
     }

    /*
     * save order data or seller value in custom table
     */

    public function execute(Observer $observer) {
       
      $orderData = $observer->getEvent()->getOrder();
      $orderSeller=$this->orderSeller->create();
      $incrementId=$orderData->getIncrementId();
      $productFactory = $this->_productFactory->create();
      foreach($orderData->getAllItems() as $item) {
          $product = $productFactory->load($item->getProductId());
          $sellerAccount[]=$product->getAttributeText('seller_account');
      }
     
      $sellerUnique=array_unique($sellerAccount);
      $sellerUniqueFilter=array_filter($sellerUnique);
   
      foreach($sellerUniqueFilter  as $sel){
                 $data['order_id']=$incrementId;
                 $data['seller_value']=$sel;
                 $orderSeller->setData($data)->save();
	   }
	     
   
     }
 
    
}
