<?php
namespace Mageplaza\SocialLogin\Block\SocialLogin;

use Mageplaza\SocialLogin\Block\SocialLogin;

class Facebook extends SocialLogin
{

    public function getLoginUrl()
    {
        return $this->facebookModel()->getFacebookLoginUrl();
    }

    public function isEnabled()
    {
        if ($this->helperFacebook()->isEnabled() && $this->helperData()->isEnabled()) {
            return true;
        } else {
            return false;
        }
    }
    protected function helperFacebook()
    {
        return $this->objectManager->create('Mageplaza\SocialLogin\Helper\Facebook\Data');
    }
    protected function helperData()
    {
        return $this->objectManager->create('Mageplaza\SocialLogin\Helper\Data');
    }

    protected function facebookModel()
    {
        return $this->objectManager->create('Mageplaza\SocialLogin\Model\Facebook');
    }
}
