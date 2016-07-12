<?php
namespace Excellence\Seller\Block\Adminhtml;
class Seller extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
		
        $this->_controller = 'adminhtml_seller';/*block grid.php directory*/
        $this->_blockGroup = 'Excellence_Seller';
        $this->_headerText = __('Seller');
        $this->_addButtonLabel = __('Add New Seller'); 
        parent::_construct();
		
    }
}
