<?php

namespace Excellence\Slider\Controller\Adminhtml\Sliderpages;

class Save extends \Magento\Backend\App\Action
{
    protected $resultPageFactory = false;
    protected $resultRedirectFactory = false;
    protected $_sliderpagesFactory = false;
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Excellence\Slider\Model\SliderpagesFactory $sliderpagesFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->resultRedirectFactory = $context->getResultRedirectFactory();
        $this->_sliderpagesFactory = $sliderpagesFactory;
    }
    public function execute()
    {
        $post = $this->getRequest()->getPostValue();

        if(isset($post)){
            $data = $this->_sliderpagesFactory->create();
            if(!empty($post['id'])){
                $data->load($post['id']);
            }

            unset($post['form_key']);
            $post['stores'] = $post['stores'][0];
            $data->setData($post);
            if($data->save()){
                $data->setStoreId($post['stores'])->save();
                $this->messageManager->addSuccess(__('Slider Has Been Saved.'));
            }
            else{
                $this->messageManager->addError(__('Some error occured while saving the slider. Please try again.'));
            }
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('*/*/');
        return $resultRedirect;
    }
}