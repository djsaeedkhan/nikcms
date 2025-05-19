<?php
namespace UsersLogs\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use UsersLogs\Model\Table\UsersTable;

/**
 * UsersLogs\Model\Table\UsersTable Test Case
 */
class UsersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \UsersLogs\Model\Table\UsersTable
     */
    public $Users;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.UsersLogs.Users',
        'plugin.UsersLogs.Roles',
        'plugin.UsersLogs.Challengeblueticks',
        'plugin.UsersLogs.Challengefollowers',
        'plugin.UsersLogs.Challengeforums',
        'plugin.UsersLogs.Challengeqanswers',
        'plugin.UsersLogs.Challenges',
        'plugin.UsersLogs.Challengeuserforms',
        'plugin.UsersLogs.Challengeuserprofiles',
        'plugin.UsersLogs.Comments',
        'plugin.UsersLogs.FormbuilderDatas',
        'plugin.UsersLogs.LmsCoursefilecans',
        'plugin.UsersLogs.LmsCourses',
        'plugin.UsersLogs.LmsCoursesessions',
        'plugin.UsersLogs.LmsCourseusers',
        'plugin.UsersLogs.LmsExamresultlists',
        'plugin.UsersLogs.LmsExamresults',
        'plugin.UsersLogs.LmsExams',
        'plugin.UsersLogs.LmsExamusers',
        'plugin.UsersLogs.LmsFactors',
        'plugin.UsersLogs.LmsPayments',
        'plugin.UsersLogs.LmsUserfactors',
        'plugin.UsersLogs.LmsUsernotes',
        'plugin.UsersLogs.LmsUserprofiles',
        'plugin.UsersLogs.Logs',
        'plugin.UsersLogs.PollVotes',
        'plugin.UsersLogs.Posts',
        'plugin.UsersLogs.Profiles',
        'plugin.UsersLogs.ShopAddresses',
        'plugin.UsersLogs.ShopFavorites',
        'plugin.UsersLogs.ShopOrderlogs',
        'plugin.UsersLogs.ShopOrderrefunds',
        'plugin.UsersLogs.ShopOrders',
        'plugin.UsersLogs.ShopOrdershippings',
        'plugin.UsersLogs.ShopOrdertexts',
        'plugin.UsersLogs.ShopOrdertokens',
        'plugin.UsersLogs.ShopPayments',
        'plugin.UsersLogs.ShopProfiles',
        'plugin.UsersLogs.ShopUseraddresses',
        'plugin.UsersLogs.SmsValidations',
        'plugin.UsersLogs.Ticketaudits',
        'plugin.UsersLogs.Ticketcomments',
        'plugin.UsersLogs.Tickets',
        'plugin.UsersLogs.TmpChallengeforms',
        'plugin.UsersLogs.TmpMembers',
        'plugin.UsersLogs.TmpPersonlikes',
        'plugin.UsersLogs.TmpPersons',
        'plugin.UsersLogs.TmpProblemforms',
        'plugin.UsersLogs.TmpProblems',
        'plugin.UsersLogs.UserMetas',
        'plugin.UsersLogs.Challengetags',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
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
    public function tearDown()
    {
        unset($this->Users);

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
