<?php
namespace Excellence\Seller\Controller\Adminhtml\Shipping;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;


class Index extends Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var \Magento\Backend\Model\View\Result\Page
     */
    protected $resultPage;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
         \Magento\Framework\AuthorizationInterface $authorization,
        PageFactory $resultPageFactory
    )
    {
        parent::__construct($context);
           $this->_authorization = $authorization;
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {  
        $this->resultPage = $this->resultPageFactory->create();  
		$this->resultPage->setActiveMenu('Excellence_Seller::seller');
		$this->resultPage ->getConfig()->getTitle()->set((__('Seller')));
		return $this->resultPage;
    }

      /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Excellence_Seller::seller');
    }

    
}
