<?php
namespace Mageplaza\SocialLogin\Block\SocialLogin;

use Magento\Framework\View\Element\Template;
use Mageplaza\SocialLogin\Block\SocialLogin;

class Twitter extends SocialLogin
{
    public function getLoginUrl()
    {
        return $this->getUrl('sociallogin/twitter/login', $this->isSecure());
    }

    public function isEnabled()
    {
        return $this->twitterHelper()->isEnabled();
    }

    protected function twitterHelper()
    {
        return $this->objectManager->create('Mageplaza\SocialLogin\Helper\Twitter\Data');
    }
}
