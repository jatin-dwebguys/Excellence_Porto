<?php

namespace Mageplaza\SocialLogin\Controller\Twitter;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Store\Model\StoreManagerInterface;
use Mageplaza\SocialLogin\Helper\Twitter\Data as TwitterHelper;
use Magento\Customer\Api\AccountManagementInterface;
use Magento\Customer\Model\Url as CustomerUrl;
use Magento\Customer\Model\Session;
use Magento\Framework\Session\SessionManagerInterface;
use Mageplaza\SocialLogin\Model\Twitter;

class Login extends Action
{
    protected $resultPageFactory;
    protected $twitterHelper;
    protected $accountManagement;
    protected $customerUrl;
    protected $customerSession;
    protected $session;
    protected $twitter;

    public function __construct(
        Context $context,
        StoreManagerInterface $storeManager,
        TwitterHelper $twitterHelper,
        PageFactory $resultPageFactory,
        AccountManagementInterface $accountManagement,
        CustomerUrl $customerUrl,
        Session $customerSession,
        SessionManagerInterface $session,
        Twitter $twitter
    ) {

        parent::__construct($context);
        $this->storeManager      = $storeManager;
        $this->twitterHelper     = $twitterHelper;
        $this->resultPageFactory = $resultPageFactory;
        $this->accountManagement = $accountManagement;
        $this->customerUrl       = $customerUrl;
        $this->customerSession   = $customerSession;
        $this->session           = $session;
        $this->twitter           = $twitter;
    }

    public function execute()
    {
        if (!$this->getAuthorizedToken()) {

            $token = $this->getAuthorization();
        } else {
            $token = $this->getAuthorizedToken();
        }

        return $token;
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
        $twitter = $this->twitter;
        $twitter->setCallbackUrl($this->twitterHelper->getAuthUrl());
        if (!is_null($this->getRequest()->getParam('oauth_token')) && !is_null($this->getRequest()->getParam('oauth_verifier'))) {
            $oauth_data = array(
                'oauth_token'    => $this->getRequest()->getParam('oauth_token'),
                'oauth_verifier' => $this->getRequest()->getParam('oauth_verifier')
            );
            try {
                $token = $twitter->getAccessToken($oauth_data, unserialize($this->session->getRequestToken()));
                $this->session->setAccessToken(serialize($token));
            } catch (\Exception $e) {
                echo $e->getMessage();
            }
            $twitter->redirect();
        } else {
            try {
                $token = $twitter->getRequestToken();


            } catch (\Exception $e) {
                echo $e->getMessage();
            }
            $this->session->setRequestToken(serialize($token));
            $twitter->redirect();
        }

        return $token;
    }

}