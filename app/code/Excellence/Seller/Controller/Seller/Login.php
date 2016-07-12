<?php
/**
 *
 * Copyright © 2015 Excellencecommerce. All rights reserved.
 */
namespace Excellence\Seller\Controller\Seller;
use Magento\Framework\Controller\ResultFactory;

class Login extends \Magento\Framework\App\Action\Action
{

    protected $resultPageFactory;
 
   
    public function __construct(
       \Magento\Framework\App\Action\Context $context,
       \Magento\Framework\View\Result\PageFactory $resultPageFactory,
       \Magento\Framework\App\Request\Http $request,
       \Excellence\Seller\Model\SellerFactory $seller,
      \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Framework\Message\ManagerInterface $messageManager
      
       
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->request = $request;
        $this->seller = $seller;
        $this->_objectManager=$objectManager;
         $this->_messageManager = $messageManager;
    }

    public function execute()
    {   
      $post = $this->request->getPostValue();
     $sellerModel= $this->seller->create();
     
     $check=$sellerModel->getCollection()->addFieldToFilter('email',$post['email'])->getFirstItem();
     
     if($check->getId()){
    
      } else { 
       $sellerModel->setData($post);
     $sellerModel->save();
      
      }
    
    
     $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
     $resultRedirect->setUrl($this->_redirect->getRefererUrl());
      
     return $resultRedirect;
        
        
    }
}
