<?php
namespace Admin\Test\TestCase\Model\Table;

use Admin\Model\Table\LmsCoursesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * Admin\Model\Table\LmsCoursesTable Test Case
 */
class LmsCoursesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Admin\Model\Table\LmsCoursesTable
     */
    public $LmsCourses;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.Admin.LmsCourses',
        'plugin.Admin.Users',
        'plugin.Admin.LmsCourseexams',
        'plugin.Admin.LmsCoursefilecans',
        'plugin.Admin.LmsCoursefiles',
        'plugin.Admin.LmsCourserelateds',
        'plugin.Admin.LmsCoursesessions',
        'plugin.Admin.LmsCourseusers',
        'plugin.Admin.LmsCourseweeks',
        'plugin.Admin.LmsUserfactors',
        'plugin.Admin.LmsUsernotes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('LmsCourses') ? [] : ['className' => LmsCoursesTable::class];
        $this->LmsCourses = TableRegistry::getTableLocator()->get('LmsCourses', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->LmsCourses);

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
