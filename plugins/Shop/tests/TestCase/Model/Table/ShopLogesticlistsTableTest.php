<?php
namespace Shop\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Shop\Model\Table\ShopLogesticlistsTable;

/**
 * Shop\Model\Table\ShopLogesticlistsTable Test Case
 */
class ShopLogesticlistsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Shop\Model\Table\ShopLogesticlistsTable
     */
    public $ShopLogesticlists;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.Shop.ShopLogesticlists',
        'plugin.Shop.ShopLogestics',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ShopLogesticlists') ? [] : ['className' => ShopLogesticlistsTable::class];
        $this->ShopLogesticlists = TableRegistry::getTableLocator()->get('ShopLogesticlists', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ShopLogesticlists);

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
}
