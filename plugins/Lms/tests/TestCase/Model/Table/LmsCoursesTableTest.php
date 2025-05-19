<?php
namespace Lms\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Lms\Model\Table\LmsCoursesTable;

/**
 * Lms\Model\Table\LmsCoursesTable Test Case
 */
class LmsCoursesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Lms\Model\Table\LmsCoursesTable
     */
    public $LmsCourses;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.Lms.LmsCourses',
        'plugin.Lms.Users',
        'plugin.Lms.LmsCourseexams',
        'plugin.Lms.LmsCoursefilecans',
        'plugin.Lms.LmsCoursefiles',
        'plugin.Lms.LmsCourserelateds',
        'plugin.Lms.LmsCoursesessions',
        'plugin.Lms.LmsCourseusers',
        'plugin.Lms.LmsCourseweeks',
        'plugin.Lms.LmsUserfactors',
        'plugin.Lms.LmsUsernotes',
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
