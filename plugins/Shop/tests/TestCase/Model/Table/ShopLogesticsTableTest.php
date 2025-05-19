<?php
namespace Shop\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Shop\Model\Table\ShopLogesticsTable;

/**
 * Shop\Model\Table\ShopLogesticsTable Test Case
 */
class ShopLogesticsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Shop\Model\Table\ShopLogesticsTable
     */
    public $ShopLogestics;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.Shop.ShopLogestics',
        'plugin.Shop.ShopLogesticlists',
        'plugin.Shop.ShopLogesticusers',
        'plugin.Shop.ShopOrderlogesticlogs',
        'plugin.Shop.ShopOrderlogestics',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ShopLogestics') ? [] : ['className' => ShopLogesticsTable::class];
        $this->ShopLogestics = TableRegistry::getTableLocator()->get('ShopLogestics', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ShopLogestics);

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
