<?php

namespace Excellence\Filter\Controller\Filter;

use Magento\Framework\Controller\ResultFactory;

class Index extends \Magento\Framework\App\Action\Action
{

  
    
    protected $resultPageFactory;

    /**
     * @param Action\Context $context
    * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
       \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\App\Request\Http $request,
        \Magento\Framework\UrlInterface $urlInterface
    ) {
        
         $this->request = $request;
         $this->urlInterface = $urlInterface;
          parent::__construct($context);
    }
  
    
    public function execute()
    { // strtolower
        $post = $this->request->getPostValue();
         $appEnd='';
        if(sizeof($post)>1){
          $url=$this->urlInterface->getCurrentUrl();
         
          $i=1;
            foreach($post as $key => $value ) {
              if($i==1){
               $appEnd.='?'.strtolower($key).'='.$value;
              } else {
                $appEnd.='&'.strtolower($key).'='.$value;

              }
              $i++;
          }
        } elseif(sizeof($post==1)) {
            foreach($post as $key => $value ) {
            $appEnd.='?'.strtolower($key).'='.$value;
            }
        }

 $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
  $redirectStringUrl=$this->_redirect->getRefererUrl();
 
 if (strpos($redirectStringUrl, '?') !== false) {
    $redString = strstr($redirectStringUrl, '?', true); 
    $redString.=$appEnd;
} else {
  $redString=$redirectStringUrl.$appEnd;
}

        $resultRedirect->setUrl($redString);
      return $resultRedirect;

        
    }
}


















