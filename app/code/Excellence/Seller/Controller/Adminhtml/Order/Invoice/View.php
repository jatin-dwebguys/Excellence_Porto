<?php

namespace Excellence\Seller\Controller\Adminhtml\Order\Invoice;

use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;

class View extends \Magento\Sales\Controller\Adminhtml\Invoice\AbstractInvoice\View
{

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        Registry $registry,
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory,
        PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context, $registry, $resultForwardFactory);
    }
  protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Excellence_Seller::seller_shipping');
    }
    /**
     * Invoice information page
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $invoice = $this->getInvoice();
        if (!$invoice) {
            /** @var \Magento\Framework\Controller\Result\Forward $resultForward */
            $resultForward = $this->resultForwardFactory->create();
            return $resultForward->forward('noroute');
        }

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Excellence_Seller::seller');
        $resultPage->getConfig()->getTitle()->prepend(__('Invoices'));
        $resultPage->getConfig()->getTitle()->prepend(sprintf("#%s", $invoice->getIncrementId()));
        $resultPage->getLayout()->getBlock(
            'seller_invoice_view'
        )->updateBackButtonUrl(
            $this->getRequest()->getParam('come_from')
        );
        return $resultPage;
    }
}
