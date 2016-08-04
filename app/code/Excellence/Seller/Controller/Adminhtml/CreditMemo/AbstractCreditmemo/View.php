<?php

namespace Excellence\Seller\Controller\Adminhtml\Creditmemo\AbstractCreditmemo;

class View extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Backend\Model\View\Result\ForwardFactory
     */
    protected $resultForwardFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
    ) {
        $this->resultForwardFactory = $resultForwardFactory;
        parent::__construct($context);
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Excellence_Seller::seller_creditmemo');
    }

    /**
     * Creditmemo information page
     *
     * @return \Magento\Backend\Model\View\Result\Forward
     */
    public function execute()
    { 
        $resultForward = $this->resultForwardFactory->create();
        $this->getRequest()->getParam('creditmemo_id');
      
        if ($this->getRequest()->getParam('creditmemo_id')) {
            $resultForward->setController('order_creditmemo');
            $resultForward->setParams(['come_from' => 'sales_creditmemo']);
            $resultForward->forward('view');
        } else {
            $resultForward->forward('noroute');
        }
        
        return $resultForward;
    }
}
