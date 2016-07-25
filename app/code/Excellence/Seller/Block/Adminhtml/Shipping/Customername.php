<?php
namespace Excellence\Seller\Block\Adminhtml\Shipping;

class Customername  extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer {

 public function render(\Magento\Framework\DataObject $row){
	  $entity_id = parent::_getValue($row);
	  
	  $objectManager =   \Magento\Framework\App\ObjectManager::getInstance();
    $connection = $objectManager->get('Magento\Framework\App\ResourceConnection')->getConnection('\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION'); 
    $result = $connection->fetchAll("SELECT * FROM sales_shipment_grid where entity_id=$entity_id");
    $customerName='';
   foreach($result as $res) {
     $customerName=$res['customer_name'];
   }
	  return $customerName;
	 }
}
