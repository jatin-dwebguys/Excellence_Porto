<?php
namespace Mageplaza\SocialLogin\Model;

use Magento\Framework\ObjectManagerInterface;

require_once 'Google/Oauth2/service/Google_ServiceResource.php';
require_once 'Google/Oauth2/service/Google_Service.php';
require_once 'Google/Oauth2/service/Google_Model.php';
require_once 'Google/Oauth2/contrib/Google_Oauth2Service.php';
require_once 'Google/Oauth2/Google_Client.php';
restore_error_handler();

class Google extends \Google_Client
{

    protected $config;
    protected $objectManagerInterface;

    public function __construct($config = array())
    {
        $this->config = new \Google_Client();
        $this->config->setClientId($this->getGoogleHelper()->getClientId());
        $this->config->setClientSecret($this->getGoogleHelper()->getClientSecret());
        $this->config->setRedirectUri($this->getGoogleHelper()->getUrl('sociallogin/google/callback'));
    }

    public function getGoogleHelper()
    {
        $om     = \Magento\Framework\App\ObjectManager::getInstance();
        $helper = $om->create('Mageplaza\SocialLogin\Helper\Google\Data');

        return $helper;
    }

    public function getConfig()
    {
        return $this->config;
    }

}