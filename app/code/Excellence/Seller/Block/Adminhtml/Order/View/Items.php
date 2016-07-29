<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Excellence\Seller\Block\Adminhtml\Order\View;

use Magento\Sales\Model\ResourceModel\Order\Item\Collection;

/**
 * Adminhtml order items grid
 */
class Items extends \Magento\Sales\Block\Adminhtml\Items\AbstractItems
{   


    //  public function __construct(
    //    \Magento\Backend\Model\Auth\Session $authSession, 
    //    \Magento\Catalog\Model\ProductFactory $ProductFactory
    // ) {
    //   $this->authSession = $authSession;
    //   $this->ProductFactory = $ProductFactory;
        
    // }

    /**
     * Retrieve required options from parent
     *
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _beforeToHtml()
    {
        if (!$this->getParentBlock()) {
            throw new \Magento\Framework\Exception\LocalizedException(__('Invalid parent block for this block'));
        }
        $this->setOrder($this->getParentBlock()->getOrder());
        parent::_beforeToHtml();
    }

   

    /**
     * Retrieve order items collection
     *
     * @return Collection
     */
    public function getItemsCollection()
    {   
        
       return $this->getOrder()->getItemsCollection();
    }
}
