<?php
declare(strict_types=1);

namespace Lms\Test\TestCase\Model\Table;

use Cake\TestSuite\TestCase;
use Lms\Model\Table\UsersTable;

/**
 * Lms\Model\Table\UsersTable Test Case
 */
class UsersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Lms\Model\Table\UsersTable
     */
    protected $Users;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'plugin.Lms.Users',
        'plugin.Lms.Roles',
        'plugin.Lms.Comments',
        'plugin.Lms.FormbuilderDatas',
        'plugin.Lms.LmsCoursefilecans',
        'plugin.Lms.LmsCourses',
        'plugin.Lms.LmsCoursesessions',
        'plugin.Lms.LmsCourseusers',
        'plugin.Lms.LmsExamresultlists',
        'plugin.Lms.LmsExamresults',
        'plugin.Lms.LmsExams',
        'plugin.Lms.LmsExamusers',
        'plugin.Lms.LmsFactors',
        'plugin.Lms.LmsPayments',
        'plugin.Lms.LmsUserfactors',
        'plugin.Lms.LmsUsernotes',
        'plugin.Lms.LmsUserprofiles',
        'plugin.Lms.Logs',
        'plugin.Lms.Posts',
        'plugin.Lms.Profiles',
        'plugin.Lms.SmsValidations',
        'plugin.Lms.Ticketaudits',
        'plugin.Lms.Ticketcomments',
        'plugin.Lms.Tickets',
        'plugin.Lms.UserMetas',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Users') ? [] : ['className' => UsersTable::class];
        $this->Users = TableRegistry::getTableLocator()->get('Users', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Users);

        parent::tearDown();
    }

    /**
     * Test beforeSave method
     *
     * @return void
     * @uses \Lms\Model\Table\UsersTable::beforeSave()
     */
    public function testBeforeSave(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \Lms\Model\Table\UsersTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \Lms\Model\Table\UsersTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
