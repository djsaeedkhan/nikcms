<?php
namespace Shop\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Shop\Model\Table\ShopOrderlogesticsTable;

/**
 * Shop\Model\Table\ShopOrderlogesticsTable Test Case
 */
class ShopOrderlogesticsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Shop\Model\Table\ShopOrderlogesticsTable
     */
    public $ShopOrderlogestics;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.Shop.ShopOrderlogestics',
        'plugin.Shop.ShopOrders',
        'plugin.Shop.ShopOrderproducts',
        'plugin.Shop.ShopLogestics',
        'plugin.Shop.Users',
        'plugin.Shop.ShopOrderlogesticlogs',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ShopOrderlogestics') ? [] : ['className' => ShopOrderlogesticsTable::class];
        $this->ShopOrderlogestics = TableRegistry::getTableLocator()->get('ShopOrderlogestics', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ShopOrderlogestics);

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
