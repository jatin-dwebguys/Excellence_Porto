<?php
namespace Excellence\Seller\Block\Adminhtml\Seller\Edit;

class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    protected function _construct()
    {
		
        parent::_construct();
        $this->setId('checkmodule_seller_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Seller Information'));
    }
}