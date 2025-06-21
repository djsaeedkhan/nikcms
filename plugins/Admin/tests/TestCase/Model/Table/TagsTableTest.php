<?php
declare(strict_types=1);

namespace Admin\Test\TestCase\Model\Table;

use Admin\Model\Table\TagsTable;
use Cake\TestSuite\TestCase;

/**
 * Admin\Model\Table\TagsTable Test Case
 */
class TagsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Admin\Model\Table\TagsTable
     */
    protected $Tags;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'plugin.Admin.Tags',
        'plugin.Admin.TagsTitleTranslation',
        'plugin.Admin.I18n',
        'plugin.Admin.Posts',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Tags') ? [] : ['className' => TagsTable::class];
        $this->Tags = TableRegistry::getTableLocator()->get('Tags', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Tags);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \Admin\Model\Table\TagsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test findOwnedBy method
     *
     * @return void
     * @uses \Admin\Model\Table\TagsTable::findOwnedBy()
     */
    public function testFindOwnedBy(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test beforeSave method
     *
     * @return void
     * @uses \Admin\Model\Table\TagsTable::beforeSave()
     */
    public function testBeforeSave(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \Admin\Model\Table\TagsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
