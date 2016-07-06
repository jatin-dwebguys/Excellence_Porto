<?php 
namespace Excellence\Filter\Observer\Adminhtml;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class Product implements ObserverInterface
{ 
  public function __construct(\Excellence\Filter\Model\FilterFactory $FilterFactory)
  {
   $this->filter = $FilterFactory;
  }
      public function execute(Observer $observer)
    {   
       $product = $observer->getEvent()->getProduct();
       $filter=$this->filter->create();

       $data=array();
       $categories=$product->getCategoryIds();
       $categoryIds=implode(',' , $product->getCategoryIds());
       $data['product_id'] = $product->getEntityId();
       $data['sku'] = $product->getSku();
       $data['category_ids'] = $categoryIds;
       $data['attribute_year'] = $product->getAttributeYear();
       $data['attribute_year_value']= $product->getAttributeText('attribute_year');
       $data['filter_make'] = $product->getFilterMake();
       $data['filter_make_value'] =$product->getAttributeText('filter_make');
       $data['filter_model'] = $product->getFilterModel();
       $data['filter_model_value'] =$product->getAttributeText('filter_model');
       $data['filter_variant'] = $product->getFilterVariant();
       $data['filter_variant_value']= $product->getAttributeText('filter_variant');
       $data['filter_engine'] = $product->getFilterEngine();
       $data['filter_engine_value'] =$product->getAttributeText('filter_engine');
    


       $filterCheck=$filter->getCollection()->addFieldToFilter('product_id', $product->getEntityId());
       if($filterCheck->getFirstItem()->getData()){
          $filterUpdate=$filter->load($filterCheck->getFirstItem()->getId());
        
          $filterUpdate->addData($data);
          $filterUpdate->save();  
       }else {
          $filter->setData($data); 
          $filter->save();
      };
         
       
      
    
    }
}
