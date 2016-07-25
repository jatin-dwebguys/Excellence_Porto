<?php
namespace Excellence\Seller\Observer;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
 use Magento\Sales\Model\Order\Email\Sender\OrderSender;


class SalesOrderPlaceAfter implements ObserverInterface
{
    
    public function __construct(
     \Magento\Catalog\Model\ProductFactory $productFactory,
     \Excellence\Seller\Model\OrderFactory $orderSeller,
      \Magento\Framework\ObjectManagerInterface $objectManager,
      \Magento\Sales\Model\OrderFactory $orderFactory,
     \Magento\Sales\Model\Order\Address\Renderer $addressRenderer,
       OrderSender $orderSender 
     ) {
      $this->_productFactory = $productFactory;
      $this->orderSeller = $orderSeller;
       $this->orderSender = $orderSender;
        $this->_objectManager= $objectManager;
         $this->orderFactory = $orderFactory;
     $this->addressRenderer = $addressRenderer;
    
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
                 $data['increment_id']=$incrementId;
                 $data['seller_value']=$sel;

                 $orderSeller->setData($data)->save();

                /*
                 * send mail to seller 
                 */  
                //shipping address 

                 $shipping_address='';
                 $shippingAddress=$orderData->getShippingAddress();
                 if($shippingAddress){
                 $shipping_address=$this->addressRenderer->format($shippingAddress, 'html');
                   } 
                 $billing_address='';
                 $billingAddress=$orderData->getBillingAddress();
                 if($billingAddress){
                 $billing_address=$this->addressRenderer->format($billingAddress, 'html'); 
                 }

                $paymentMethod=$orderData->getPayment()->getMethodInstance()->getTitle();
               
               /* Receiver Detail  */
                $receiverInfo = [
                    'name' => $sel,
                    'email' => $sel
                ];
                  
                /* Sender Detail  */
                $senderInfo = [
                    'name' => 'Sender Name',
                    'email' => 'sender@addess.com',
                ];
                 
                 
                /* Assign values for your template variables  */
                $emailTemplateVariables = array();
                $emailTempVariables['order'] = $orderData;
                $emailTempVariables['formattedShippingAddress'] = $shipping_address;
                $emailTempVariables['formattedBillingAddress'] = $billing_address;
                $emailTempVariables['payment_html'] = $paymentMethod;
                $emailTempVariables['seller_email'] = $sel;
                                    

                /* We write send mail function in helper because if we want to 
                   use same in other action then we can call it directly from helper */ 
                 
                /* call send mail method from helper or where you define it*/ 
                $this->_objectManager->get('Excellence\Seller\Helper\Email')->yourCustomMailSendMethod(
                      $emailTempVariables,
                      $senderInfo,
                      $receiverInfo
                  );
	   

     }

     }
 
    
}
