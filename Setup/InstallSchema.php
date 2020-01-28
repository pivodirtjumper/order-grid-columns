<?php

namespace Pivodirtjumper\OrderGridColumns\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{

    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        //$setup->getTable($setup->getConnection()->getTableName('sales/order_grid'))
        if (version_compare($context->getVersion(), '0.0.1', '<')) {
            $setup->getConnection()->addColumn(
                $setup->getTable('sales_order_grid'),
                'coupon_code',
                [
                    'type' => Table::TYPE_TEXT,
                    'length' => 255,
                    'nullable' => true,
                    'comment' => 'Coupon code value for order'
                ]
            );
            $setup->getConnection()->addColumn(
                $setup->getTable('sales_order_grid'),
                'discount_amount',
                [
                    'type' => Table::TYPE_DECIMAL,
                    'length' => '(20,4)',
                    'nullable' => true,
                    'comment' => 'Discount amount for order'
                ]
            );
        }

        $setup->endSetup();
    }

}