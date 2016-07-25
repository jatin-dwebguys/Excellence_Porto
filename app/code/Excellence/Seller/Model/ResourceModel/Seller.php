<?php
/**
 * Copyright © 2015 Excellence. All rights reserved.
 */
namespace Excellence\Seller\Model\ResourceModel;

/**
 * Seller resource
 */
class Seller extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('excellence_seller_detail', 'id');
    }

  
}
