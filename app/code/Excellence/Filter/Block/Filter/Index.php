<?php
/**
 * Copyright © 2015 Excellence . All rights reserved.
 */
namespace Excellence\Filter\Block\Filter;

class Index extends \Magento\Framework\View\Element\Template
{  

	
  

    public function getFilters(){

    $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
    $EavModel = $objectManager->create('Magento\Catalog\Model\ResourceModel\Eav\Attribute');

     $attribute_id = array('169', '170','171','172' ,'173');
     return $EavModel->getCollection()->addFieldToFilter('attribute_id', array('in' => $attribute_id));
    }
 

}
