<?php
namespace Shop\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Shop\Model\Table\ShopOrdersTable;

/**
 * Shop\Model\Table\ShopOrdersTable Test Case
 */
class ShopOrdersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Shop\Model\Table\ShopOrdersTable
     */
    public $ShopOrders;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.Shop.ShopOrders',
        'plugin.Shop.Users',
        'plugin.Shop.ShopAddresses',
        'plugin.Shop.ShopOrderlogesticlogs',
        'plugin.Shop.ShopOrderlogestics',
        'plugin.Shop.ShopOrderlogs',
        'plugin.Shop.ShopOrderproducts',
        'plugin.Shop.ShopOrderrefunds',
        'plugin.Shop.ShopOrdershippings',
        'plugin.Shop.ShopOrdertexts',
        'plugin.Shop.ShopOrdertokens',
        'plugin.Shop.ShopPayments',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ShopOrders') ? [] : ['className' => ShopOrdersTable::class];
        $this->ShopOrders = TableRegistry::getTableLocator()->get('ShopOrders', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ShopOrders);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
