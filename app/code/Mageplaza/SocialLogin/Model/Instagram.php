<?php

namespace Mageplaza\SocialLogin\Model;
require_once 'Instagram/Instagram.php';
use Mageplaza\SocialLogin\Helper\Instagram\Data as HelperInstagram;

class Instagram extends \Instagram
{
    protected $config;
    protected $helperInstagram;
    protected $instagram;


    public function __construct(HelperInstagram $helperInstagram)
    {
        $this->helperInstagram = $helperInstagram;
        $ClientID              = $this->helperInstagram->getClientId();
        $ClientSecret          = $this->helperInstagram->getClientSecret();
        $RedirectUri           = $this->helperInstagram->getUrl('sociallogin/instagram/callback');
        $this->config         = array(
            'apiKey'      => $ClientID,
            'apiSecret'   => $ClientSecret,
            'apiCallback' => $RedirectUri,
        );
        $this->instagram      = new \Instagram($this->config);
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function getInstagram()
    {
        return $this->instagram;
    }
}