<?php

namespace Mageplaza\SocialLogin\Model;
use Magento\Framework\Model\AbstractModel;
class Social extends AbstractModel
{
    /**
     * Define resource model
     */
    protected function _construct()
    {
        $this->_init('Mageplaza\SocialLogin\Model\ResourceModel\Social');
    }
}