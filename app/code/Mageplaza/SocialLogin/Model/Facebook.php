<?php

namespace Mageplaza\SocialLogin\Model;

use Mageplaza\SocialLogin\Helper\Facebook\Data as DataHelper;
use Mageplaza\SocialLogin\Model\Facebook\Authentication;


class Facebook
{

    protected $dataHelper;

    public function __construct(DataHelper $dataHelper)
    {
        $this->dataHelper = $dataHelper;
    }

    /**
     * get facebook user profile
     *
     * @return null|the
     */
    public function getFacebookUser()
    {
        $facebook = $this->newFacebook();
        $userId   = $facebook->getUser();
        $fbme     = null;

        if ($userId) {
            try {
                $fbme = $facebook->api('/me?fields=email,first_name,last_name');
            } catch (\Exception $e) {

            }
        }

        return $fbme;
    }

    /**
     * get facebook url api
     *
     * @return type
     */
    public function getFacebookLoginUrl()
    {
        $facebook = $this->newFacebook();
        $loginUrl = $facebook->getLoginUrl(
            array(
                'display'      => 'popup',
                'redirect_uri' => $this->dataHelper->getAuthUrl(),
                'scope'        => 'email',
            )
        );

        return $loginUrl;
    }

    /**
     * inital facebook authentication
     *
     * @return \Facebook
     */
    public function newFacebook()
    {
        $facebook = new Authentication(array(
            'appId'  => $this->dataHelper->getAppId(),
            'secret' => $this->dataHelper->getAppSecret(),
            'cookie' => true,
        ));

        return $facebook;
    }

}
