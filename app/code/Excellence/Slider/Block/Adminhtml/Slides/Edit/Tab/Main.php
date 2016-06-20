<?php
namespace Excellence\Slider\Block\Adminhtml\Slides\Edit\Tab;

class Main extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    protected $_systemStore;
    protected $_sliders;
    protected $_status;
    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Store\Model\System\Store $systemStore
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Store\Model\System\Store $systemStore,
        \Excellence\Slider\Model\Adminhtml\Config\Source\Sliders $sliders,
        \Excellence\Slider\Model\Adminhtml\Config\Source\Status $status,
        array $data = []
    ) {
        $this->_systemStore = $systemStore;
        $this->_sliders = $sliders;
        $this->_status = $status;
        parent::__construct($context, $registry, $formFactory, $data);
    }
  
    protected function _prepareForm()
    {
        /* @var $model \Magento\Cms\Model\Page */
        $model = $this->_coreRegistry->registry('slides_edit');
        /*
         * Checking if user have permissions to save information
         */
        if ($this->_isAllowedAction('Excellence_Slider::save')) {
            $isElementDisabled = false;
        } else {
            $isElementDisabled = true;
        }
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix('slide_');
        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('slide Information')]);
        if ($model->getId()) {
            $fieldset->addField('id', 'hidden', ['name' => 'id']);
        }
        $fieldset->addField(
            'image_name',
            'text',
            [
                'name' => 'image_name',
                'label' => __('Image Name'),
                'title' => __('Image Name'),
                'required' => true,
                'disabled' => $isElementDisabled
            ]
        );
        $caption_comment = "<font size=2 color='#666666'>&uarr;&nbsp;".__("Leave blank if you don't want to show caption with image.")."</font></p>";
        $fieldset->addField(
            'title',
            'text',
            [
                'name' => 'title',
                'label' => __('Caption'),
                'title' => __('Caption'),
                'required' => false,
                'disabled' => $isElementDisabled,
                'after_element_html' => $caption_comment
            ]
        );
        $fieldset->addField(
            'image',
            'image',
            [
                'title' => __('Image'),
                'label' => __('Image'),
                'name' => 'image',
                'note' => 'Allowed image types: jpg, jpeg, gif, png',
            ]
        );
        $fieldset->addField(
            'image_position',
            'text',
            [
                'name' => 'image_position',
                'label' => __('Image Position'),
                'title' => __('Image Position'),
                'required' => true,
                'disabled' => $isElementDisabled
            ]
        );
        $fieldset->addField(
            'slider_name',
            'select',
            [
                'name' => 'slider_name',
                'label' => __('Slider Name'),
                'title' => __('Slider Name'),
                'class' => 'required-entry',
                'required' => true,
                'values' => $this->_sliders->toOptionArray(),
            ]
        );
         $fieldset->addField(
            'is_active',
            'select',
            [
                'name' => 'is_active',
                'label' => __('Status'),
                'title' => __('Status'),
                'class' => 'required-entry',
                'required' => true,
                'values' => $this->_status->toOptionArray(),
            ]
        );
        $fieldset->addField(
            'content',
            'text',
            [
                'name' => 'content',
                'label' => __('URL'),
                'title' => __('URL'),
                'required' => true,
                'disabled' => $isElementDisabled
            ]
        );

        $form->setValues($model->getData());
        $this->setForm($form);
        return parent::_prepareForm();
    }
    /**
     * Prepare label for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabLabel()
    {
        return __('Slide Information');
    }
    /**
     * Prepare title for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabTitle()
    {
        return __('Slide Information');
    }
    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }
    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }
    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}