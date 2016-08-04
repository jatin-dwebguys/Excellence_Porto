<?php

namespace Excellence\Seller\Block\Adminhtml\Invoice;

class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * @var \Magento\Framework\Module\Manager
     */
    protected $moduleManager;

    /**
     * @var \Magento\Eav\Model\ResourceModel\Entity\Attribute\Set\CollectionFactory]
     */
    protected $_setsFactory;

    /**
     * @var \Magento\Catalog\Model\ProductFactory
     */
    protected $_productFactory;

    /**
     * @var \Magento\Catalog\Model\Product\Type
     */
    protected $_type;

    /**
     * @var \Magento\Catalog\Model\Product\Attribute\Source\Status
     */
    protected $_status;
	protected $_collectionFactory;

    /**
     * @var \Magento\Catalog\Model\Product\Visibility
     */
    protected $_visibility;

    /**
     * @var \Magento\Store\Model\WebsiteFactory
     */
    protected $_websiteFactory;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \Magento\Store\Model\WebsiteFactory $websiteFactory
     * @param \Magento\Eav\Model\ResourceModel\Entity\Attribute\Set\CollectionFactory $setsFactory
     * @param \Magento\Catalog\Model\ProductFactory $productFactory
     * @param \Magento\Catalog\Model\Product\Type $type
     * @param \Magento\Catalog\Model\Product\Attribute\Source\Status $status
     * @param \Magento\Catalog\Model\Product\Visibility $visibility
     * @param \Magento\Framework\Module\Manager $moduleManager
     * @param array $data
     *
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Magento\Store\Model\WebsiteFactory $websiteFactory,
	//\Excellence\Seller\Model\ResourceModel\Seller\Collection $collectionFactory,
        \Magento\Sales\Model\ResourceModel\Order\Invoice\Collection $invoiceCollection,
       // \Excellence\Seller\Model\ResourceModel\Invoicecollection\Colletion $invColl,
          \Magento\Sales\Model\OrderFactory $OrderFactory,
        \Magento\Framework\Module\Manager $moduleManager,
         \Magento\Backend\Model\Auth\Session $authSession, 
         \Excellence\Seller\Model\OrderFactory $sellerorderFactory,
      //  \Magento\Framework\Data\CollectionFactory $collectionFactory,
        array $data = []
    ) {
		
	//	$this->_collectionFactory = $collectionFactory;
     //   $this->invoColl = $invColl;
        // $this->_collectionFactory = $collectionFactory;
       $this->invoiceCollection = $invoiceCollection;
        $this->_websiteFactory = $websiteFactory;
        $this->moduleManager = $moduleManager;
         $this->authSession = $authSession;
         $this->orderFactory = $OrderFactory;
         $this->sellerorderFactory = $sellerorderFactory;
       

        parent::__construct($context, $backendHelper, $data);
    }
 

    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
		
        $this->setId('productGrid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(false);
       
    }


    /**
     * @return Store
     */
    protected function _getStore()
    {
        $storeId = (int)$this->getRequest()->getParam('store', 0);
        return $this->_storeManager->getStore($storeId);
    }

    /**
     * @return $this
     */
    protected function _prepareCollection()
    {   
    
   
  // echo '<pre>';

  // print_r($this->invoiceCollection->getData());
   
  //  die;
   
 
     try{
	      $email=$this->authSession->getUser()->getEmail();
              $roleName = $this->authSession->getUser()->getRole()->getRoleName();
              $sellerOrder=$this->sellerorderFactory->create(); 
        

             if($roleName=='Supplier'){

                 $sellerOrderIds=$sellerOrder->getCollection()->addFieldToFilter('seller_value',$email);
           
               $orderIds= array();
               foreach($sellerOrderIds as $sel){
                $orderIds[]=$sel->getOrderId();
                }
                     if(count($orderIds) > 0) {
                           $collection = $this->invoiceCollection->addFieldToFilter('order_id',$orderIds)
                       ->addAttributeToSort('entity_id', 'DESC');
                     } else {

                           $collection=$this->invoiceCollection->addFieldToFilter('order_id','0')
                       ->addAttributeToSort('entity_id', 'DESC');
                              }
            
             } else {
                //    $sellerOrderIds=$sellerOrder->getCollection();
             
                //  $incrementIds= array();
                //   foreach($sellerOrderIds as $sel){
                // $incrementIds[]=$sel->getOrderId();
                // }
                //   $collection = $this->invoiceCollection->addAttributeToFilter('increment_id',array('in'=> $incrementIds));
               $collection = $this->invoiceCollection->addAttributeToSort('entity_id', 'DESC');

             }


          	$this->setCollection($collection);

			parent::_prepareCollection();
		  
			return $this;
		}
		catch(Exception $e)
		{
			echo $e->getMessage();die;
		}
    }

    /**
     * @param \Magento\Backend\Block\Widget\Grid\Column $column
     * @return $this
     */
    protected function _addColumnFilterToCollection($column)
    {
        if ($this->getCollection()) {
            if ($column->getId() == 'websites') {
                $this->getCollection()->joinField(
                    'websites',
                    'catalog_product_website',
                    'website_id',
                    'product_id=entity_id',
                    null,
                    'left'
                );
            }
        }
        return parent::_addColumnFilterToCollection($column);
    }

    /**
     * @return $this
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function _prepareColumns()
    {   

        $this->addColumn(
            'increment_id',
            [
                'header' => __('Invoice'),
                'index' => 'increment_id',
                'class' => 'increment_id'
            ]
        );
       
         $this->addColumn(
            'created_at',
            [
                'header' => __('Invoice Date'),
                'type' => 'date',
                'index' => 'created_at',
                'class' => 'created_at'
            ]
        );  

        $this->addColumn(
            'entity_id',
            [
                'header' => __('Order #'),
               'index' => 'entity_id',
                'renderer' => 'Excellence\Seller\Block\Adminhtml\Invoice\Orderincrementid',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id'
            ]
        );
		$this->addColumn(
            'customer_name',
            [
                'header' => __('Bill-to Name'),
                'index' => 'entity_id',
                'renderer' => 'Excellence\Seller\Block\Adminhtml\Invoice\Customername',
                'filter' => false,
                'class' => 'customer_name'
            ]
        );

		$this->addColumn(
            'order_date',
            [
                'header' => __('Order Date'),
                'index' => 'entity_id',
                 'renderer' => 'Excellence\Seller\Block\Adminhtml\Invoice\Orderdate',
                 'filter' => false,
                'class' => 'order_date'
            ]
        );
		
        
         $this->addColumn(
            'sku',
            [
                'header' => __('Items Sku'),
                'index' => 'order_id',
                 'renderer' => 'Excellence\Seller\Block\Adminhtml\Invoice\Sku',
                'class' => 'sku'
            ]
        );
        //  $this->addColumn(
        //     'grand_total',
        //     [
        //         'header' => __('Amount'),
        //         'index' => 'grand_total',
        //          'renderer' => 'Excellence\Seller\Block\Adminhtml\Invoice\Amount',
        //         'class' => 'grand_total'
        //     ]
        // );

           $this->addColumn(
            'status',
            [
                'header' => __('Status'),
                'index' => 'entity_id',
                 'renderer' => 'Excellence\Seller\Block\Adminhtml\Status',
                 'filter' => false,
                'class' => 'status'
            ]
        );
        
        //  $this->addColumn(
        //     'status',
        //     [
        //         'header' => __('Status'),
        //         'index' => 'status',
        //         'class' => 'status'
        //     ]
        // );
         
       
		/*{{CedAddGridColumn}}*/

        $block = $this->getLayout()->getBlock('grid.bottom.links');
        if ($block) {
            $this->setChild('grid.bottom.links', $block);
        }

        return parent::_prepareColumns();
    }

     /**
     * @return $this
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('id');

        $this->getMassactionBlock()->addItem(
            'delete',
            array(
                'label' => __('Delete'),
                'url' => $this->getUrl('seller/*/massDelete'),
                'confirm' => __('Are you sure?')
            )
        );
        return $this;
    }

    /**
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('seller/*/index', ['_current' => true]);
    }

    /**
     * @param \Magento\Catalog\Model\Product|\Magento\Framework\Object $row
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl(
            'seller/*/view',
            ['store' => $this->getRequest()->getParam('store'), 'invoice_id' => $row->getId()]
        );
    }
}
