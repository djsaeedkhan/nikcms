<?php
namespace Admin\Test\TestCase\Model\Table;

use Admin\Model\Table\PostsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * Admin\Model\Table\PostsTable Test Case
 */
class PostsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Admin\Model\Table\PostsTable
     */
    public $Posts;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.Admin.Posts',
        'plugin.Admin.Users',
        'plugin.Admin.Comments',
        'plugin.Admin.PostMetas',
        'plugin.Admin.ShopFavorites',
        'plugin.Admin.ShopOrderproducts',
        'plugin.Admin.ShopProductMetas',
        'plugin.Admin.ShopProductParams',
        'plugin.Admin.ShopProductdetails',
        'plugin.Admin.ShopProductmajors',
        'plugin.Admin.ShopProductprices',
        'plugin.Admin.ShopProductstocks',
        'plugin.Admin.Tickets',
        'plugin.Admin.Categories',
        'plugin.Admin.I18n',
        'plugin.Admin.Tags',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Posts') ? [] : ['className' => PostsTable::class];
        $this->Posts = TableRegistry::getTableLocator()->get('Posts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Posts);

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
