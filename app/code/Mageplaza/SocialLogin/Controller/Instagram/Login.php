<?php
namespace Mageplaza\SocialLogin\Controller\Instagram;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Mageplaza\SocialLogin\Model\Instagram;
use Magento\Store\Model\StoreManagerInterface;
use Mageplaza\SocialLogin\Helper\Instagram\Data as HelperInstagram;
use Mageplaza\SocialLogin\Helper\Data as HelperData;
use Magento\Customer\Api\AccountManagementInterface;
use Magento\Customer\Model\Url as CustomerUrl;
use Magento\Customer\Model\Session;

class Login extends Action
{
    protected $resultPageFactory;
    protected $instagram;
    protected $helperData;
    protected $helperInstagram;
    protected $accountManagement;
    protected $customerUrl;
    protected $session;


    public function __construct(
        Context $context,
        Instagram $instagram,
        StoreManagerInterface $storeManager,
        HelperInstagram $helperInstagram,
        HelperData $helperData,
        PageFactory $resultPageFactory,
        AccountManagementInterface $accountManagement,
        CustomerUrl $customerUrl,
        Session $customerSession
    ) {

        parent::__construct($context);
        $this->instagram         = $instagram;
        $this->storeManager      = $storeManager;
        $this->helperData        = $helperData;
        $this->helperInstagram   = $helperInstagram;
        $this->resultPageFactory = $resultPageFactory;
        $this->accountManagement = $accountManagement;
        $this->customerUrl       = $customerUrl;
        $this->session           = $customerSession;
    }

    public function execute()
    {
        $instagram = $this->instagram->getInstagram();
        $loginUrl  = $instagram->getLoginUrl();
        exit(header('Location: ' . $loginUrl));
    }
}