<?php
/**
 * Copyright © 2015 Excellence. All rights reserved.
 */
namespace Excellence\Filter\Model\ResourceModel;

/**
 * Filter resource
 */
class Filter extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('filter_filter', 'id');
    }

  
}
