<?php
namespace Excellence\Slider\Block;

use Excellence\Slider\Model\Adminhtml\Config\Source\Status;
use Excellence\Slider\Model\Adminhtml\Config\Source\Pages;
use Excellence\Slider\Model\ResourceModel\Slides\CollectionFactory;
use Excellence\Slider\Model\SliderpagesFactory;
  
class Slider extends \Magento\Framework\View\Element\Template
{   
	protected $_collectionFactory;
    protected $_sliderPagesFactory;
    protected $_scopeConfigObject;
    protected $_page;
    protected $_registry;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfigObject,
        CollectionFactory $collectionFactory,
        SliderpagesFactory $sliderPagesFactory,
        \Magento\Cms\Model\Page $page,
        \Magento\Framework\Registry $registry,
        array $data = []
    )
    {
        $this->_scopeConfigObject = $scopeConfigObject;
    	  $this->_collectionFactory = $collectionFactory;
        $this->_sliderPagesFactory = $sliderPagesFactory;
        $this->_page = $page;
        $this->_registry = $registry;
        parent::__construct($context, $data);
    }
    public function setSlider($position)
    {
        $sliderId = $this->_sliderPagesFactory->create();
        if(!empty($this->_registry->registry('current_category'))){
            //category page
            $category = $this->_registry->registry('current_category');
            $slider_id = $sliderId->getSliderId(Pages::CATEGORY_PAGE, $category->getID(), $position);
        }    
        if(!empty($this->_registry->registry('current_product'))){
            //product page
            $product = $this->_registry->registry('current_product');
            $slider_id = $sliderId->getSliderId(Pages::PRODUCT_PAGE, $product->getID(), $position);
        }
        if(!empty($this->_page->getId())){
            $slider_id = $sliderId->getSliderId(Pages::CMS_PAGE, $this->_page->getId(), $position);
            //cms page
        }
        if(!empty($slider_id)){
            $slides = $this->_collectionFactory->create()
                        ->addFieldToFilter('is_active', Status::STATUS_ENABLED)
                        ->addFieldToFilter('slider_name', $slider_id)
                        ->setOrder('image_position', 'ASC');
            $collectionData = $slides->getData();
        }
        else{
            $collectionData = null;
        }
        
        $this->setSlidesModel($collectionData);
        $sliderType = $this->_scopeConfigObject->getValue('slider/slider/select_slider');
        $this->setSliderType($sliderType);
    }

    public function checkoutPageSlider($pageTypeId, $position)
    {
        $sliderId = $this->_sliderPagesFactory->create();
        if($pageTypeId == Pages::CART_PAGE){
          $slider_id = $sliderId->getSliderId(Pages::CART_PAGE,'', $position);
        }
        if($pageTypeId == Pages::CHECKOUT_PAGE){
          $slider_id = $sliderId->getSliderId(Pages::CHECKOUT_PAGE,'', $position);
        }
        $slides = $this->_collectionFactory->create()
                        ->addFieldToFilter('is_active', Status::STATUS_ENABLED)
                        ->addFieldToFilter('slider_name', $slider_id)
                        ->setOrder('image_position', 'ASC');;
        $collectionData = $slides->getData();
        $this->setSlidesModel($collectionData);
        $sliderType = $this->_scopeConfigObject->getValue('slider/slider/select_slider');
        $this->setSliderType($sliderType);
    }
}