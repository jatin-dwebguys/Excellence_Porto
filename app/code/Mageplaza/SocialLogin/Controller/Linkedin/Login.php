<?php

namespace Mageplaza\SocialLogin\Controller\Linkedin;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Mageplaza\SocialLogin\Model\Linkedin;
use Magento\Store\Model\StoreManagerInterface;
use Mageplaza\SocialLogin\Helper\Linkedin\Data as HelperLinkedin;
use Mageplaza\SocialLogin\Helper\Data as HelperData;
use Magento\Customer\Api\AccountManagementInterface;
use Magento\Customer\Model\Url as CustomerUrl;
use Magento\Customer\Model\Session;
use Magento\Framework\Controller\ResultFactory;


class Login extends Action
{
    protected $resultPageFactory;
    protected $linkedin;
    protected $helperData;
    protected $helperLinkedin;
    protected $accountManagement;
    protected $customerUrl;
    protected $session;
    protected $resultFactory;


    public function __construct(
        Context $context,
        Linkedin $linkedin,
        StoreManagerInterface $storeManager,
        HelperLinkedin $helperLinkedin,
        HelperData $helperData,
        PageFactory $resultPageFactory,
        AccountManagementInterface $accountManagement,
        CustomerUrl $customerUrl,
        Session $customerSession
    ) {

        parent::__construct($context);
        $this->linkedin          = $linkedin;
        $this->storeManager      = $storeManager;
        $this->helperData        = $helperData;
        $this->helperLinkedin    = $helperLinkedin;
        $this->resultPageFactory = $resultPageFactory;
        $this->accountManagement = $accountManagement;
        $this->customerUrl       = $customerUrl;
        $this->session           = $customerSession;
        $this->resultFactory     = $context->getResultFactory();
    }

    public function execute()
    {
        $config['base_url']        = $this->getBaseUrl() . 'sociallogin/linkedin/login';
        $config['callback_url']    = $this->getBaseUrl() . 'sociallogin/linkedin/callback';
        $config['linkedin_access'] = $this->helperLinkedin->getApiKey();
        $config['linkedin_secret'] = $this->helperLinkedin->getClientKey();
        if (empty($config['linkedin_access'])) {
            die("<script type=\"text/javascript\">try{window.opener.location.reload(true);}catch(e){window.opener.location.href=\"" . $this->storeManager->getStore()->getUrl() . "\"} window.close();</script>");

        } else if (empty($config['linkedin_secret'])) {
            die("<script type=\"text/javascript\">try{window.opener.location.reload(true);}catch(e){window.opener.location.href=\"" . $this->storeManager->getStore()->getUrl() . "\"} window.close();</script>");
        }

        //        $linkedin = Mage::helper('linkedinlogin/linkedin');
        $this->linkedin->setParams($config['linkedin_access'], $config['linkedin_secret'], $config['callback_url']);
        $this->linkedin->getRequestToken();
        $this->session->setRequestToken(serialize($this->linkedin->request_token));
        $this->_redirect($this->linkedin->generateAuthorizeUrl());

        return $this;
    }

    public function getBaseUrl()
    {
        return $this->storeManager->getStore()->getUrl();
    }
}