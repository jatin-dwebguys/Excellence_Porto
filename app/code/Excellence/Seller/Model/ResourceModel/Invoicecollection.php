<?php
/**
 * Copyright © 2015 Excellence. All rights reserved.
 */
namespace Excellence\Seller\Model\ResourceModel;

/**
 * Seller resource
 */
class Invoicecollection extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('sales_invoice_grid', 'entity_id');
    }

  
}
