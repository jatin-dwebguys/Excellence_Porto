<?php
/**
 * Mail Transport
 */
namespace Excellence\Test\Model;
 
class Transport extends \Zend_Mail_Transport_Smtp implements \Magento\Framework\Mail\TransportInterface
{
    /**
     * @var \Magento\Framework\Mail\MessageInterface
     */
    protected $_message;
 
    /**
     * @param MessageInterface $message
     * @param null $parameters
     * @throws \InvalidArgumentException
     */
    public function __construct(\Magento\Framework\Mail\MessageInterface $message)
    {
        if (!$message instanceof \Zend_Mail) {
            throw new \InvalidArgumentException('The message should be an instance of \Zend_Mail');
        }
        
         $smtpHost= 'mailtrap.io';//your smtp host  ';
         $smtpConf = [
            'auth' => 'login',//auth type
            'tsl' => 'tsl', 
            'port' => '465',
            'username' => '8268747b2dad3a',//smtm user name
            'password' => '1b6ff90326d47e'//smtppassword 
         ];

        parent::__construct($smtpHost, $smtpConf);
        $this->_message = $message;
    }
 
    /**
     * Send a mail using this transport
     * @return void
     * @throws \Magento\Framework\Exception\MailException
     */
    public function sendMessage()
    {
        try {
            parent::send($this->_message);
        } catch (\Exception $e) {
            throw new \Magento\Framework\Exception\MailException(new \Magento\Framework\Phrase($e->getMessage()), $e);
        }
    }
}
