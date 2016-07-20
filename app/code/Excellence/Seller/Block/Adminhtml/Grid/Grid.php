<?php
namespace Excellence\Seller\Block\Adminhtml\Grid;


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
		\Excellence\Seller\Model\ResourceModel\Seller\Collection $collectionFactory,
        \Magento\Sales\Model\ResourceModel\Order\Collection $orderCollection,
        \Magento\Framework\Module\Manager $moduleManager,
         \Magento\Backend\Model\Auth\Session $authSession, 
         \Excellence\Seller\Model\OrderFactory $sellerorderFactory,
        array $data = []
    ) {
		
		$this->_collectionFactory = $collectionFactory;
        $this->orderCollection = $orderCollection;
        $this->_websiteFactory = $websiteFactory;
        $this->moduleManager = $moduleManager;
         $this->authSession = $authSession;
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
		try{
			
			 $email=$this->authSession->getUser()->getEmail();
             $roleName = $this->authSession->getUser()->getRole()->getRoleName();
              $sellerOrder=$this->sellerorderFactory->create(); 
        

             if($roleName=='Supplier'){
               
                 $sellerOrderIds=$sellerOrder->getCollection()->addFieldToFilter('seller_value',$email);
             
               $incrementIds= array();
               foreach($sellerOrderIds as $sel){
                $incrementIds[]=$sel->getOrderId();
                }
               $collection = $this->orderCollection->addAttributeToFilter('increment_id',array('in'=> $incrementIds));
             } else {
                   $sellerOrderIds=$sellerOrder->getCollection();
             
                 $incrementIds= array();
                  foreach($sellerOrderIds as $sel){
                $incrementIds[]=$sel->getOrderId();
                }
                  $collection = $this->orderCollection->addAttributeToFilter('increment_id',array('in'=> $incrementIds));
             }
     echo '<pre>';      
     print_r($collection->getData());
     die();
         
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
                'header' => __('ID'),
               'index' => 'increment_id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id'
            ]
        );
		$this->addColumn(
            'store_name',
            [
                'header' => __('Purchase Point'),
                'index' => 'store_name',
                'class' => 'store_name'
            ]
        );
		$this->addColumn(
            'customer_firstname',
            [
                'header' => __('Customer Name'),
                'index' => 'customer_firstname',
                'class' => 'customer_firstname'
            ]
        );
		
         $this->addColumn(
            'created_at',
            [
                'header' => __('Purchase Date'),
                'type' => 'date',
                'index' => 'created_at',
                'class' => 'created_at'
            ]
        );  

         $this->addColumn(
            'base_grand_total',
            [
                'header' => __('Grand Total (Base)'),
                'index' => 'base_grand_total',
                'class' => 'base_grand_total'
            ]
        );
         

         $this->addColumn(
            'grand_total',
            [
                'header' => __('Grand Total (Purchased)'),
                'index' => 'grand_total',
                'class' => 'grand_total'
            ]
        );
        
         $this->addColumn(
            'status',
            [
                'header' => __('Status'),
                'index' => 'status',
                'class' => 'status'
            ]
        );

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
            'seller/*/edit',
            ['store' => $this->getRequest()->getParam('store'), 'id' => $row->getId()]
        );
    }
}
