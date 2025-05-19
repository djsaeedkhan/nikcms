<?php
namespace Lms\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Lms\Model\Table\LmsCoursecategoriesTable;

/**
 * Lms\Model\Table\LmsCoursecategoriesTable Test Case
 */
class LmsCoursecategoriesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Lms\Model\Table\LmsCoursecategoriesTable
     */
    public $LmsCoursecategories;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.Lms.LmsCoursecategories',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('LmsCoursecategories') ? [] : ['className' => LmsCoursecategoriesTable::class];
        $this->LmsCoursecategories = TableRegistry::getTableLocator()->get('LmsCoursecategories', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->LmsCoursecategories);

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
