<?php
namespace Admin\Test\TestCase\Model\Table;

use Admin\Model\Table\PostsI18nTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * Admin\Model\Table\PostsI18nTable Test Case
 */
class PostsI18nTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Admin\Model\Table\PostsI18nTable
     */
    public $PostsI18n;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.Admin.PostsI18n',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('PostsI18n') ? [] : ['className' => PostsI18nTable::class];
        $this->PostsI18n = TableRegistry::getTableLocator()->get('PostsI18n', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PostsI18n);

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
