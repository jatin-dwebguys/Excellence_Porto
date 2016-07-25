<?php
/**
 * @author		Sashas
 * @category    Sashas
 * @package     Sashas_CustomerAttribute
 * @copyright   Copyright (c) 2015 Sashas IT Support Inc. (http://www.extensions.sashas.org) 
 */
namespace Excellence\Seller\Setup;


use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

/**
* @codeCoverageIgnore
*/

class InstallData implements InstallDataInterface

{

/**
* EAV setup factory
* @var EavSetupFactory
*/
private $eavSetupFactory;

/**
* Init
* @param EavSetupFactory $eavSetupFactory
*/
public function __construct(EavSetupFactory $eavSetupFactory)
{
$this->eavSetupFactory = $eavSetupFactory;
}

/**
* {@inheritdoc}
* @SuppressWarnings(PHPMD.ExcessiveMethodLength)
*/

public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
{
/** @var EavSetup $eavSetup */
$eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
/**
* Add attributes to the eav/attribute
*/
$eavSetup->addAttribute(

\Magento\Catalog\Model\Product::ENTITY,
'seller_account',
[
'group' => 'General',
'type' => 'varchar',
'backend' => '',
'frontend' => '',
'label' => 'Select Seller',
'input' => 'multiselect',
'class' => '',
'source' => '',
'global' => \Magento\Catalog\Model\ResourceModel\Eav\Attribute::SCOPE_GLOBAL,
'visible' => true,
'required' => false,
'user_defined' => true,
'default' => '',
'searchable' => false,
'filterable' => false,
'comparable' => false,
'visible_on_front' => false,
'used_in_product_listing' => true,
'unique' => false,
'apply_to' => 'simple,configurable,virtual,bundle,downloadable'

]);
}

}