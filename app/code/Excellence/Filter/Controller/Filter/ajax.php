<?php

namespace Excellence\Filter\Controller\Filter;

use Magento\Framework\Controller\ResultFactory;

class ajax extends \Magento\Framework\App\Action\Action
{

	
    
    protected $resultPageFactory;

    /**
     * @param Action\Context $context
    * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
       \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\App\Request\Http $request,
        \Magento\Framework\UrlInterface $urlInterface,
        \Excellence\Filter\Model\FilterFactory $filterFactory,
      \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
    ) {
        
          $this->resultJsonFactory = $resultJsonFactory;
         $this->request = $request;
         $this->urlInterface = $urlInterface;
         $this->filterFactory = $filterFactory;
          parent::__construct($context);
    }
	
    
    public function execute()
    { // strtolower
        $post = $this->request->getPostValue();
       
        $filterModel=$this->filterFactory->create();

        $filter=array();

        if($post['code']=='attribute_year'){
             $dataFilter=$filterModel->getCollection()->addFieldToFilter($post['code'],$post['value']);
               $result=$dataFilter->getData();
               foreach($result as $key => $value){
              $filter['filter_make'][$value['filter_make']]=$value['filter_make_value'];
             }
        }
        if($post['code']=='filter_make'){
            $dataFilter=$filterModel->getCollection()->addFieldToFilter($post['code'],$post['value'])
         ->addFieldToFilter($post['attribute_code_year_id'],$post['attribute_code_year_value']);
       
           $result=$dataFilter->getData();
         
         foreach($result as $key => $value){
             $filter['filter_model'][$value['filter_model']]=$value['filter_model_value'];
             }
        }
     
       if($post['code']=='filter_model'){
            $dataFilter=$filterModel->getCollection()->addFieldToFilter($post['code'],$post['value'])
         ->addFieldToFilter($post['attribute_code_year_id'],$post['attribute_code_year_value'])
        ->addFieldToFilter($post['attribute_code_make_id'],$post['attribute_code_make_value']);
       
           $result=$dataFilter->getData();
         
         foreach($result as $key => $value){
             $filter['filter_variant'][$value['filter_variant']]=$value['filter_variant_value'];
             }
        }

        if($post['code']=='filter_variant'){
            $dataFilter=$filterModel->getCollection()->addFieldToFilter($post['code'],$post['value'])
         ->addFieldToFilter($post['attribute_code_year_id'],$post['attribute_code_year_value'])
        ->addFieldToFilter($post['attribute_code_make_id'],$post['attribute_code_make_value'])
        ->addFieldToFilter($post['attribute_code_model_id'],$post['attribute_code_model_value']);

           $result=$dataFilter->getData();
         
         foreach($result as $key => $value){
             $filter['filter_engine'][$value['filter_engine']]=$value['filter_engine_value'];
             }
        }

       
       
      

       // foreach($result as $key => $value){
       //        $filter['filter_make'][$value['filter_make']]=$value['filter_engine_value'];
       //       // $filter['filter_model'][$value['filter_model']]=$value['filter_model_value'];
       //      //  $filter['filter_variant'][$value['filter_variant']]=$value['filter_variant_value'];
       //      //  $filter['filter_engine'][$value['filter_engine']]=$value['filter_engine_value'];
       // }
       // if($post['code']=='filter_make'){
     //   array_shift($filter);
     //    }


     return  $this->resultJsonFactory->create()->setData($filter);
   }
      
}


















