<?php
/**
 * Copyright © 2015 Excellence. All rights reserved.
 */
namespace Excellence\Seller\Model\ResourceModel;

/**
 * Seller resource
 */
class Order extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('sales_order_seller', 'id');
    }

  
}
