<?php
namespace Mageplaza\SocialLogin\Block\SocialLogin;

use Magento\Framework\View\Element\Template;
use Mageplaza\SocialLogin\Block\SocialLogin;

class Linkedin extends SocialLogin
{
    public function getLoginUrl()
    {
        return $this->getUrl('sociallogin/linkedin/login');
    }

}
