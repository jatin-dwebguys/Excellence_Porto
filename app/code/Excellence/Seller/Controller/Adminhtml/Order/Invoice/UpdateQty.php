<?php
/**
 *
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Excellence\Seller\Controller\Adminhtml\Order\Invoice;

use Magento\Framework\Exception\LocalizedException;
use Magento\Backend\App\Action;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\Result\RawFactory;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Sales\Model\Service\InvoiceService;

/**
 * Class UpdateQty
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class UpdateQty extends \Magento\Sales\Controller\Adminhtml\Invoice\AbstractInvoice\View
{
    /**
     * @var JsonFactory
     */
    protected $resultJsonFactory;

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var RawFactory
     */
    protected $resultRawFactory;

    /**
     * @var InvoiceService
     */
    private $invoiceService;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
     * @param PageFactory $resultPageFactory
     * @param JsonFactory $resultJsonFactory
     * @param RawFactory $resultRawFactory
     * @param InvoiceService $invoiceService
     */
    public function __construct(
        Context $context,
        Registry $registry,
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory,
        PageFactory $resultPageFactory,
        JsonFactory $resultJsonFactory,
        RawFactory $resultRawFactory,
        InvoiceService $invoiceService
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->resultRawFactory = $resultRawFactory;
        $this->invoiceService = $invoiceService;
        parent::__construct($context, $registry, $resultForwardFactory);
    }

    /**
     * Update items qty action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {   
             $orderId = $this->getRequest()->getParam('order_id');
             $order = $this->_objectManager->create('Magento\Sales\Model\Order')->load($orderId);
            
             $items=$order->getAllItems();


            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $this->authSession = $objectManager->create('\Magento\Backend\Model\Auth\Session');
            $product = $objectManager->create('\Magento\Catalog\Model\Product');
              $email=$this->authSession->getUser()->getEmail();
            $roleName = $this->authSession->getUser()->getRole()->getRoleName();
            $productIds=array();
           // $_items=$block->getItemsCollection();
            $updateItems=array();
            $filterItem= array();
        foreach ($items as $_item){
            
                /* changes */
            if($roleName=='Supplier'){ 
               $sellerEmail=$product->load($_item->getProductId())->getAttributeText('seller_account');
               if($email !== $sellerEmail){
                    $updateItems[]=$_item->getItemId();
                    $filterItem[$_item->getItemId()]=0;
               } else {
                 $filterItem[$_item->getItemId()] = (int)$_item->getQtyOrdered();
               }

           }
        }

//print_r($filterItem);
//print_r($updateItems);
     //   die;

      try {  
           // $orderId = $this->getRequest()->getParam('order_id');
            $invoiceData = $this->getRequest()->getParam('invoice', []);
            $first=$this->getRequest()->getParam('first');
            $invoiceCustome=array();
              if(isset($first)){
                $invoiceData['items']= $filterItem; 
                $invoiceData['comment_text']='';
              } else {

                 foreach($updateItems as $upitem){
                      $invoiceData['items'][$upitem]= 0;
                   }
              }


            $invoiceItems = isset($invoiceData['items']) ? $invoiceData['items'] : [];
            /** @var \Magento\Sales\Model\Order $order */
       //  print_r($invoiceItems);
      //   die;

          //  $order = $this->_objectManager->create('Magento\Sales\Model\Order')->load($orderId);


            if (!$order->getId()) {
                throw new \Magento\Framework\Exception\LocalizedException(__('The order no longer exists.'));
            }

            if (!$order->canInvoice()) {
                throw new \Magento\Framework\Exception\LocalizedException(
                    __('The order does not allow an invoice to be created.')
                );
            }

            $invoice = $this->invoiceService->prepareInvoice($order, $invoiceItems);

            if (!$invoice->getTotalQty()) {
                throw new \Magento\Framework\Exception\LocalizedException(
                    __('You can\'t create an invoice without products.')
                );
            }
            $this->registry->register('current_invoice', $invoice);
            // Save invoice comment text in current invoice object in order to display it in corresponding view
            $invoiceRawCommentText = $invoiceData['comment_text'];
            $invoice->setCommentText($invoiceRawCommentText);

            /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
            $resultPage = $this->resultPageFactory->create();
            $resultPage->getConfig()->getTitle()->prepend(__('Invoices'));
           
           $response = $resultPage->getLayout()->getBlock('order_items1')->toHtml();
        } catch (LocalizedException $e) {
            $response = ['error' => true, 'message' => $e->getMessage()];
        } catch (\Exception $e) {
            $response = ['error' => true, 'message' => __('Cannot update item quantity.')];
        }
        if (is_array($response)) {
            /** @var \Magento\Framework\Controller\Result\Json $resultJson */
            $resultJson = $this->resultJsonFactory->create();
            $resultJson->setData($response);
            return $resultJson;
        } else {
            /** @var \Magento\Framework\Controller\Result\Raw $resultRaw */
            $resultRaw = $this->resultRawFactory->create();
            $resultRaw->setContents($response);
            return $resultRaw;
        }
    }
}
