<?php
namespace Excellence\Seller\Block\Adminhtml\Invoice;

class Customername  extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer {

 public function render(\Magento\Framework\DataObject $row){
	  $entity_id = parent::_getValue($row);
	  
	  $objectManager =   \Magento\Framework\App\ObjectManager::getInstance();
    $connection = $objectManager->get('Magento\Framework\App\ResourceConnection')->getConnection('\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION'); 
    $result = $connection->fetchAll("SELECT * FROM sales_invoice_grid where entity_id=$entity_id");
    $billingName='';
   foreach($result as $res) {
     $billingName=$res['billing_name'];
   }
	  return $billingName;
	 }
}
