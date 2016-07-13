<?php
/**
 *
 * Copyright © 2015 Excellencecommerce. All rights reserved.
 */
namespace Excellence\Seller\Controller\Seller;
use Magento\Framework\Controller\ResultFactory;
use Magento\Store\Model\ScopeInterface;

class Login extends \Magento\Framework\App\Action\Action
{

    protected $resultPageFactory;
 
   
    public function __construct(
       \Magento\Framework\App\Action\Context $context,
       \Magento\Framework\View\Result\PageFactory $resultPageFactory,
       \Magento\Framework\App\Request\Http $request,
       \Excellence\Seller\Model\SellerFactory $seller,
       \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Framework\Message\ManagerInterface $messageManager,
         \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
          \Magento\Eav\Setup\EavSetupFactory $eavSetupFactory,
    \Magento\Store\Model\StoreManagerInterface $storeManager,
    \Magento\Catalog\Model\ResourceModel\Eav\Attribute $attributeFactory
   ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->request = $request;
        $this->seller = $seller;
        $this->_objectManager=$objectManager;
         $this->_messageManager = $messageManager;
         $this->scopeConfig = $scopeConfig;
          $this->_eavSetupFactory = $eavSetupFactory;
    $this->_storeManager = $storeManager;
    $this->_attributeFactory = $attributeFactory;
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
  
   // add attribute options
    $attribute_arr = $post['first_name'];
/*
*  load attribute by attribute code 
*/
    $attributeInfo=$this->_attributeFactory->getCollection()
               ->addFieldToFilter('attribute_code',['eq'=>"seller_account"])
               ->getFirstItem();
$attribute_id = $attributeInfo->getAttributeId();

$option=array();
$option['attribute_id'] = $attributeInfo->getAttributeId();

$storeid= $this->_storeManager->getStore()->getId();


//foreach($attribute_arr as $key=>$value){
  //  $option['value'][$value][0]=$value;
   // foreach($allStores as $store){
        $option['value'][$attribute_arr][$storeid] = $attribute_arr;
   // }
//}
        $option['value'][$attribute_arr][0]=$attribute_arr;


$eavSetup = $this->_eavSetupFactory->create();
$eavSetup->addAttributeOption($option);



    //send mail to user and  owner
   //store owner email or name

 $email = $this->scopeConfig->getValue('trans_email/ident_support/email',ScopeInterface::SCOPE_STORE);
 $name  = $this->scopeConfig->getValue('trans_email/ident_support/name',ScopeInterface::SCOPE_STORE);




    /* Receiver Detail  */
      $receiverInfo = [
        'name' => $post['first_name'],
        'email' => $post['email']
    ];
 
 
    /* Sender Detail  */
    $senderInfo = [
        'name' => $name,
        'email' => $email,
    ];
 
 
    /* Assign values for your template variables  */
    $emailTemplateVariables = array();
    $emailTempVariables['email'] = $post['email'];

                        

    /* We write send mail function in helper because if we want to 
       use same in other action then we can call it directly from helper */ 
     
    /* call send mail method from helper or where you define it*/ 
    $this->_objectManager->get('Excellence\Test\Helper\Email')->yourCustomMailSendMethod(
          $emailTempVariables,
          $senderInfo,
          $receiverInfo
      );



    
     $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
     $resultRedirect->setUrl($this->_redirect->getRefererUrl());
      
     return $resultRedirect;
        
        
    }
}
