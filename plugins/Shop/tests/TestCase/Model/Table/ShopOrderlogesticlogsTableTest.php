<?php
namespace Shop\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Shop\Model\Table\ShopOrderlogesticlogsTable;

/**
 * Shop\Model\Table\ShopOrderlogesticlogsTable Test Case
 */
class ShopOrderlogesticlogsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Shop\Model\Table\ShopOrderlogesticlogsTable
     */
    public $ShopOrderlogesticlogs;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.Shop.ShopOrderlogesticlogs',
        'plugin.Shop.ShopLogestics',
        'plugin.Shop.ShopOrders',
        'plugin.Shop.ShopOrderlogestics',
        'plugin.Shop.Users',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ShopOrderlogesticlogs') ? [] : ['className' => ShopOrderlogesticlogsTable::class];
        $this->ShopOrderlogesticlogs = TableRegistry::getTableLocator()->get('ShopOrderlogesticlogs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ShopOrderlogesticlogs);

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
