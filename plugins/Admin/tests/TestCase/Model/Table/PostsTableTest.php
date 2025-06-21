<?php
declare(strict_types=1);

namespace Admin\Test\TestCase\Model\Table;

use Admin\Model\Table\PostsTable;
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
    protected $Posts;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'plugin.Admin.Posts',
        'plugin.Admin.PostsTitleTranslation',
        'plugin.Admin.PostsSummaryTranslation',
        'plugin.Admin.PostsContentTranslation',
        'plugin.Admin.PostsI18n',
        'plugin.Admin.Users',
        'plugin.Admin.Comments',
        'plugin.Admin.PostMetas',
        'plugin.Admin.Categories',
        'plugin.Admin.Tags',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
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
    protected function tearDown(): void
    {
        unset($this->Posts);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \Admin\Model\Table\PostsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test beforeSave method
     *
     * @return void
     * @uses \Admin\Model\Table\PostsTable::beforeSave()
     */
    public function testBeforeSave(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \Admin\Model\Table\PostsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
