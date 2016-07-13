<?php
namespace Excellence\Test\Controller\Index;
 
 
class Index extends \Magento\Framework\App\Action\Action
{
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
         \Magento\Framework\View\Result\PageFactory $resultPageFactory,
          \Magento\Framework\Stdlib\DateTime\TimezoneInterface $localeDate,
          \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
            \Magento\Framework\ObjectManagerInterface $objectManager, 
        \Psr\Log\LoggerInterface $logger )
    {    
       $this->_objectManager= $objectManager;
        $this->resultPageFactory = $resultPageFactory; 
        $this->timezoneTime= $localeDate;
        $this->logger = $logger;
         $this->_transportBuilder = $transportBuilder;
        return parent::__construct($context);
    }
     
    public function execute()
    {   
        /* Here we prepare data for our email  */
 
 
/* Receiver Detail  */
$receiverInfo = [
    'name' => 'surendra',
    'email' => 'rohityadav786yadav@gmail.com'
];
 
 
/* Sender Detail  */
$senderInfo = [
    'name' => 'Sender Name',
    'email' => 'sender@addess.com',
];
 
 
/* Assign values for your template variables  */
$emailTemplateVariables = array();
$emailTempVariables['email'] = 'rohityadav786yadav@gmail.com';

                    

/* We write send mail function in helper because if we want to 
   use same in other action then we can call it directly from helper */ 
 
/* call send mail method from helper or where you define it*/ 
$this->_objectManager->get('Excellence\Test\Helper\Email')->yourCustomMailSendMethod(
      $emailTempVariables,
      $senderInfo,
      $receiverInfo
  );
     
      }
  

}

