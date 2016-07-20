<?php
/**
 * Copyright © 2015 Excellence. All rights reserved.
 */

namespace Excellence\Seller\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
	
        $installer = $setup;

        $installer->startSetup();

		/**
         * Create table 'excellence_seller_detail'
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('excellence_seller_detail')
        )
		->addColumn(
            'id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'excellence_seller_detail'
        )
		->addColumn(
            'first_name',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            '64k',
            [],
            'first_name'
        )
		->addColumn(
            'last_name',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            '64k',
            [],
            'last_name'
        )
		->addColumn(
            'email',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            '64k',
            [],
            'email'
        )
		/*{{CedAddTableColumn}}}*/
		
		
        ->setComment(
            'Excellence Seller seller_seller'
        );
		
		$installer->getConnection()->createTable($table);
		/*{{CedAddTable}}*/



       /**
         * Create table 'excellence_seller_detail'
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('sales_order_seller')
        )
        ->addColumn(
            'id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'id'
        )
        ->addColumn(
            'order_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            '64k',
            [],
            'Order_id'
        )
        ->addColumn(
            'seller_value',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            '64k',
            [],
            'seller_value'
        );
        
        $installer->getConnection()->createTable($table);


        $installer->endSetup();

    }
}
