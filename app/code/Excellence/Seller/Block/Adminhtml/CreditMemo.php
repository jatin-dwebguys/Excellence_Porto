<?php
namespace Excellence\Seller\Block\Adminhtml;
class CreditMemo extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
		
        $this->_controller = 'adminhtml_creditmemo';/*block grid.php directory*/
        $this->_blockGroup = 'Excellence_Seller';
        $this->_headerText = __('Grid');
       
        parent::_construct();
		
    }
}
