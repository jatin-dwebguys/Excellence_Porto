<?php

namespace Excellence\Seller\Controller\Seller;

use Magento\Framework\Controller\ResultFactory;
use Magento\Store\Model\ScopeInterface;

class Login extends \Magento\Framework\App\Action\Action {

    protected $resultPageFactory;

    public function __construct(
    \Magento\Framework\App\Action\Context $context,
            \Magento\Framework\View\Result\PageFactory $resultPageFactory,
            \Magento\Framework\App\Request\Http $request,
            \Excellence\Seller\Model\SellerFactory $seller,
            \Magento\Framework\ObjectManagerInterface $objectManager,
            \Magento\Framework\Message\ManagerInterface $messageManager,
             \Magento\Framework\Controller\Result\RedirectFactory $resultRedirectFactory,
            \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
            \Magento\Eav\Setup\EavSetupFactory $eavSetupFactory,
            \Magento\Store\Model\StoreManagerInterface $storeManager,
            \Magento\Catalog\Model\ResourceModel\Eav\Attribute $attributeFactory,
            \Magento\User\Model\UserFactory $userFactory,
             \Magento\Catalog\Model\Session $catalogSession 

    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->request = $request;
        $this->seller = $seller;
        $this->_objectManager = $objectManager;
        $this->_messageManager = $messageManager;
        $this->scopeConfig = $scopeConfig;
        $this->_eavSetupFactory = $eavSetupFactory;
        $this->_storeManager = $storeManager;
        $this->_attributeFactory = $attributeFactory;
        $this->_userFactory = $userFactory;
        $this->resultRedirectFactory=$resultRedirectFactory;
        $this->catalogSession = $catalogSession;

    }

    public function execute() {
        
        $post = $this->request->getPostValue();
        $sellerModel = $this->seller->create();

        /*
         *  save seller detail in seller_detail table
         */
        $check = $sellerModel->getCollection()->addFieldToFilter('email', $post['email'])->getFirstItem();
        if ($check->getId()) {
            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            $resultRedirect->setUrl($this->_redirect->getRefererUrl());
            $this->catalogSession->setErrorSession(1);
            
            return $resultRedirect;
        } else {
            $sellerModel->setData($post);
            $sellerModel->save();
        }

        // add attribute options
        $attribute_arr = $post['email'];
        /*
         *  load attribute by attribute code 
         */
        $attributeInfo = $this->_attributeFactory->getCollection()
                ->addFieldToFilter('attribute_code', ['eq' => "seller_account"])
                ->getFirstItem();

        $attribute_id = $attributeInfo->getAttributeId();
        $option = array();
        $option['attribute_id'] = $attributeInfo->getAttributeId();

        $storeid = $this->_storeManager->getStore()->getId();
        $option['value'][$attribute_arr][$storeid] = $attribute_arr;
        $option['value'][$attribute_arr][0] = $attribute_arr;


        $eavSetup = $this->_eavSetupFactory->create();
        $eavSetup->addAttributeOption($option);

        /*
         *  create admin user 
         */
        $userArray = array();
        $userArray['username'] = $post['email'];
        $userArray['firstname'] = $post['first_name'];
        $userArray['lastname'] = $post['last_name'];
        $userArray['email'] = $post['email'];
        $userArray['password'] = $post['passwordnew'];
        $userArray['is_active'] = 1;

        $role = array();
        $role[0] = 3;
        $userArray['roles'] = $role;

        $model = $this->_userFactory->create();
        $model->setData($userArray);
        $model->setRoleId($userArray['roles']);
        $model->save();


        /// end of create admin user 


        /* send mail to user and  owner
         * store owner email or name
         */

        $email = $this->scopeConfig->getValue('trans_email/ident_support/email', ScopeInterface::SCOPE_STORE);
        $name = $this->scopeConfig->getValue('trans_email/ident_support/name', ScopeInterface::SCOPE_STORE);

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
        /* call send mail method from helper or where you define it */
       $this->_objectManager->get('Excellence\Test\Helper\Email')->yourCustomMailSendMethod(
               $emailTempVariables, $senderInfo, $receiverInfo
       );

        /*
         * send mail to user and  owner end
         */
      

       $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
       $resultRedirect->setUrl($this->_redirect->getRefererUrl());

       $this->catalogSession->setSuccessRegistor(1);
 

        return $resultRedirect;
    }

}
