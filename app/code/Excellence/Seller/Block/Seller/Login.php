<?php
/**
 * Copyright © 2015 Excellence . All rights reserved.
 */
namespace Excellence\Seller\Block\Seller;
use Excellence\Seller\Block\BaseBlock;
use Magento\Framework\UrlInterface;

class Login extends BaseBlock
{
	
	 
	
	
   public function _prepareLayout()
  {
   //set page title
   $this->pageConfig->getTitle()->set(__('Create New Seller Account'));

    return parent::_prepareLayout();
   }  
   
   public function getPostActionUrl(){
    return $this->getControllerUrl('seller/seller/login');
   }
   
}
