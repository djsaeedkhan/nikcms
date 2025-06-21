<?php
declare(strict_types=1);

namespace Admin\Test\TestCase\Model\Table;

use Admin\Model\Table\CategoriesTable;
use Cake\TestSuite\TestCase;

/**
 * Admin\Model\Table\CategoriesTable Test Case
 */
class CategoriesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Admin\Model\Table\CategoriesTable
     */
    protected $Categories;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'plugin.Admin.Categories',
        'plugin.Admin.CategoriesTitleTranslation',
        'plugin.Admin.CategoriesDescriptionTranslation',
        'plugin.Admin.CategoriesI18n',
        'plugin.Admin.Posts',
        'plugin.Admin.ParentCategories',
        'plugin.Admin.ChildrenCategories',
        'plugin.Admin.CategorieMetas',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Categories') ? [] : ['className' => CategoriesTable::class];
        $this->Categories = TableRegistry::getTableLocator()->get('Categories', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Categories);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \Admin\Model\Table\CategoriesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test beforeSave method
     *
     * @return void
     * @uses \Admin\Model\Table\CategoriesTable::beforeSave()
     */
    public function testBeforeSave(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \Admin\Model\Table\CategoriesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
