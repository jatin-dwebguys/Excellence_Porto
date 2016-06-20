<?php

namespace Excellence\Slider\Model\Adminhtml\Config\Source;
 
class Specificpageoptions
{
    protected $pageFactory;
    protected $categoryFactory;
    protected $productFactory;

    public function __construct(
        \Magento\Cms\Model\PageFactory $pageFactory,
        \Magento\Catalog\Model\CategoryFactory $categoryFactory,
        \Magento\Catalog\Model\ProductFactory $productFactory

    )
    {
        $this->pageFactory = $pageFactory->create();
        $this->categoryFactory = $categoryFactory->create();
        $this->productFactory = $productFactory->create();
    }  

    public function getCmsPages()
    {
        $optionArray = array();
        array_push($optionArray, array('value' => 0, 'label' => '-- Select --'));
        foreach ($this->pageFactory->getCollection()->getData() as $data) {
            array_push($optionArray, array('value' => $data['page_id'], 'label' => $data['title']));
        }
        return $optionArray;
                
    }

    // public function getCategoryPages()
    // {
    //     $optionArray = array();
    //     array_push($optionArray, array('value' => 0, 'label' => '-- Select --'));
    //     // foreach ($this->categoryFactory->getCollection()->setStoreId(5)->getData() as $data) {
    //     //     array_push($optionArray, array('value' => $data['entity_id'], 'label' => $this->categoryFactory->load($data['entity_id'])->getData('name')));
    //     // }
    //     return $optionArray;
                
    // }

    // public function getProductPages()
    // {
    //     $optionArray = array();
    //     array_push($optionArray, array('value' => 0, 'label' => '-- Select --'));
    //     // foreach ($this->productFactory->getCollection()->getData() as $data) {
    //     //     array_push($optionArray, array('value' => $data['entity_id'], 'label' => $this->productFactory->load($data['entity_id'])->getData('name')));
    //     // }
    //     return $optionArray;
    // }

}