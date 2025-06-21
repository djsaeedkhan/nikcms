<?php
declare(strict_types=1);

namespace Admin\Test\TestCase\Model\Table;

use Admin\Model\Table\PostsCategoriesTable;
use Cake\TestSuite\TestCase;

/**
 * Admin\Model\Table\PostsCategoriesTable Test Case
 */
class PostsCategoriesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Admin\Model\Table\PostsCategoriesTable
     */
    protected $PostsCategories;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'plugin.Admin.PostsCategories',
        'plugin.Admin.Posts',
        'plugin.Admin.Categories',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('PostsCategories') ? [] : ['className' => PostsCategoriesTable::class];
        $this->PostsCategories = TableRegistry::getTableLocator()->get('PostsCategories', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->PostsCategories);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \Admin\Model\Table\PostsCategoriesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test beforeSave method
     *
     * @return void
     * @uses \Admin\Model\Table\PostsCategoriesTable::beforeSave()
     */
    public function testBeforeSave(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \Admin\Model\Table\PostsCategoriesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
