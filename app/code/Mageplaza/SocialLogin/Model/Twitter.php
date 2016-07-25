<?php


namespace Mageplaza\SocialLogin\Model;

use Mageplaza\SocialLogin\Helper\Twitter\Data as TwitterHelper;

class Twitter extends \Zend_Oauth_Consumer
{

    protected $twitterHelper;
    protected $_options = null;


    public function __construct(TwitterHelper $twitterHelper)
    {

        $this->_config       = new \Zend_Oauth_Config;
        $this->twitterHelper = $twitterHelper;
        $this->_options      = array(
            'consumerKey'     => $this->twitterHelper->getConsumerKey(),
            'consumerSecret'  => $this->twitterHelper->getConsumerSecret(),
            'signatureMethod' => 'HMAC-SHA1',
            'version'         => '1.0',
            'requestTokenUrl' => 'https://api.twitter.com/oauth/request_token',
            'accessTokenUrl'  => 'https://api.twitter.com/oauth/access_token',
            'authorizeUrl'    => 'https://api.twitter.com/oauth/authorize'
        );
        $this->_config->setOptions($this->_options);
    }

    public function setCallbackUrl($url)
    {
        $this->_config->setCallbackUrl($url);
    }

}
