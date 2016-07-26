<?php

namespace Excellence\Seller\Observer;

use \Psr\Log\LoggerInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
 use Magento\Sales\Model\Order\Email\Sender\OrderSender;


class CheckoutSubmitAllAfter implements ObserverInterface {

    protected $logger;
    protected $orderFactory;
    protected $addressRenderer;

    public function __construct(
           \Excellence\Seller\Model\OrderFactory $sellerorderFactory,
            OrderSender $orderSender 
           
    ) {
          $this->sellerorderFactory = $sellerorderFactory;
       $this->orderSender = $orderSender;
    }

    

    public function execute(Observer $observer) {
   
     $orderId = $observer->getEvent()->getOrder()->getId();
     $incrementId = $observer->getEvent()->getOrder()->getIncrementId();
     $sellerOrder=$this->sellerorderFactory->create();
     $sellerOrderIds=$sellerOrder->getCollection()->addFieldToFilter('increment_id', $incrementId);
    
    
   foreach($sellerOrderIds as $ord) {
    
        $ord->setOrderId($orderId);
        $ord->save();
         
     }
      
 
      
    }

}
