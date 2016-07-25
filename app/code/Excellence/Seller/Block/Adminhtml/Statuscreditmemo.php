<?php
namespace Excellence\Seller\Block\Adminhtml;

class Statuscreditmemo  extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer {

  public function __construct( \Magento\Sales\Model\Order\Creditmemo $orderFactory
     ) {
	 $this->orderFactory = $orderFactory;
	
    }

	 public function render(\Magento\Framework\DataObject $row){
	  $entity_id = parent::_getValue($row);
	
          $order = $this->orderFactory->load($entity_id);
          $status = $order->getStates();
          $state = $order->getState();
          
        
          $i=1;
   foreach($status as $st) {
          $statusNew=$st->getText();
          if($state == $i){
           break;
          }
          $i++;
     }
      
	  return $statusNew;
	 }
}
