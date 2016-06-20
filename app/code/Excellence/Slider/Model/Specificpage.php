<?php
namespace Excellence\Slider\Model;
class Specificpage extends \Magento\Framework\Model\AbstractModel
{
    public function __construct(
        \Magento\Cms\Model\PageFactory $pageFactory
    )
    {
        $this->pageFactory = $pageFactory;
        return parent::__construct();
    }


    public function test()
    {
        print_r('test566'); die();
        $page = $this->pageFactory->create();
        print_r($page->getData()); die();
    }
}
