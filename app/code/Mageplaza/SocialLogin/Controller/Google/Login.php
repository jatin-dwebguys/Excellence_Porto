<?php

namespace Mageplaza\SocialLogin\Controller\Google;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Mageplaza\SocialLogin\Model\Google;
use Magento\Store\Model\StoreManagerInterface;
use Mageplaza\SocialLogin\Helper\Google\Data as HelperGoogle;
use Mageplaza\SocialLogin\Helper\Data as HelperData;
use Magento\Customer\Api\AccountManagementInterface;
use Magento\Customer\Model\Url as CustomerUrl;
use Magento\Customer\Model\Session;

class Login extends Action
{
    protected $resultPageFactory;
    protected $google;
    protected $helperData;
    protected $helperGoogle;
    protected $accountManagement;
    protected $customerUrl;
    protected $session;


    public function __construct(
        Context $context,
        Google $google,
        StoreManagerInterface $storeManager,
        HelperGoogle $helperGoogle,
        HelperData $helperData,
        PageFactory $resultPageFactory,
        AccountManagementInterface $accountManagement,
        CustomerUrl $customerUrl,
        Session $customerSession
    ) {

        parent::__construct($context);
        $this->google            = $google;
        $this->storeManager      = $storeManager;
        $this->helperData        = $helperData;
        $this->helperGoogle      = $helperGoogle;
        $this->resultPageFactory = $resultPageFactory;
        $this->accountManagement = $accountManagement;
        $this->customerUrl       = $customerUrl;
        $this->session           = $customerSession;
    }

    public function execute()
    {
        if ($this->helperData->isEnabled() && $this->helperGoogle->isEnabled()) {
            if (!$this->getAuthorizedToken()) {

                $token = $this->getAuthorization();
            } else {
                $token = $this->getAuthorizedToken();
            }

            return $token;
        }

        return false;
    }

    public function getAuthorizedToken()
    {
        $token = false;
        if (!is_null($this->session->getAccessToken())) {
            $token = unserialize($this->session->getAccessToken());
        }

        return $token;
    }

    public function getAuthorization()
    {
        $scope = array(
            'https://www.googleapis.com/auth/userinfo.profile',
            'https://www.googleapis.com/auth/userinfo.email'
        );
        //        $gglogin = Mage::getModel('gglogin/gglogin');
        $this->google->setScopes($scope);

        $this->google->authenticate();

        $authUrl = $this->google->createAuthUrl();
        header('Localtion: ' . $authUrl);
        die(0);
    }

}