<?php
declare(strict_types=1);

namespace Ticketing\Test\TestCase\Model\Table;

use Cake\TestSuite\TestCase;
use Ticketing\Model\Table\PostsTable;

/**
 * Ticketing\Model\Table\PostsTable Test Case
 */
class PostsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Ticketing\Model\Table\PostsTable
     */
    protected $Posts;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'plugin.Ticketing.Posts',
        'plugin.Ticketing.Users',
        'plugin.Ticketing.Comments',
        'plugin.Ticketing.PostMetas',
        'plugin.Ticketing.ShopFavorites',
        'plugin.Ticketing.ShopOrderproducts',
        'plugin.Ticketing.ShopProductMetas',
        'plugin.Ticketing.ShopProductParams',
        'plugin.Ticketing.ShopProductdetails',
        'plugin.Ticketing.ShopProductmajors',
        'plugin.Ticketing.ShopProductprices',
        'plugin.Ticketing.ShopProductstocks',
        'plugin.Ticketing.Tickets',
        'plugin.Ticketing.Categories',
        'plugin.Ticketing.I18n',
        'plugin.Ticketing.Tags',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Posts') ? [] : ['className' => PostsTable::class];
        $this->Posts = $this->getTableLocator()->get('Posts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Posts);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \Ticketing\Model\Table\PostsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \Ticketing\Model\Table\PostsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
