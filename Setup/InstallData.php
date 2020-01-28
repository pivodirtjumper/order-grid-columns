<?php

namespace Pivodirtjumper\OrderGridColumns\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

use Magento\Sales\Model\ResourceModel\Order\Collection;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory;

class InstallData implements InstallDataInterface
{

    protected $orderCollectionFactory;

    public function __construct(
        CollectionFactory $orderCollectionFactory
    ) {
        $this->orderCollectionFactory = $orderCollectionFactory;
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        if (version_compare($context->getVersion(), '0.0.1', '<')) {
            // May consider different update mechanism for really huge order tables.
            $select = $setup->getConnection()
                ->select()
                ->joinLeft(
                    ['so' => 'sales_order'],
                    "so.entity_id = sog.entity_id",
                    [
                        'coupon_code' => 'coupon_code',
                        'discount_amount' => 'discount_amount'
                    ]
                );
            $query = $setup->getConnection()->updateFromSelect($select, ['sog' => 'sales_order_grid']);
            $setup->getConnection()->query($query);
        }

        $setup->endSetup();
    }

}