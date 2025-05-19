<?php
namespace Lms\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
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
    public $Users;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.Lms.Users',
        'plugin.Lms.Roles',
        'plugin.Lms.Challengeblueticks',
        'plugin.Lms.Challengefollowers',
        'plugin.Lms.Challengeforums',
        'plugin.Lms.Challengeqanswers',
        'plugin.Lms.Challenges',
        'plugin.Lms.Challengeuserforms',
        'plugin.Lms.Challengeuserprofiles',
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
        'plugin.Lms.PollVotes',
        'plugin.Lms.Posts',
        'plugin.Lms.Profiles',
        'plugin.Lms.ShopAddresses',
        'plugin.Lms.ShopFavorites',
        'plugin.Lms.ShopOrderlogs',
        'plugin.Lms.ShopOrderrefunds',
        'plugin.Lms.ShopOrders',
        'plugin.Lms.ShopOrdershippings',
        'plugin.Lms.ShopOrdertexts',
        'plugin.Lms.ShopOrdertokens',
        'plugin.Lms.ShopPayments',
        'plugin.Lms.ShopProfiles',
        'plugin.Lms.ShopUseraddresses',
        'plugin.Lms.SmsValidations',
        'plugin.Lms.Ticketaudits',
        'plugin.Lms.Ticketcomments',
        'plugin.Lms.Tickets',
        'plugin.Lms.TmpChallengeforms',
        'plugin.Lms.TmpMembers',
        'plugin.Lms.TmpPersonlikes',
        'plugin.Lms.TmpPersons',
        'plugin.Lms.TmpProblemforms',
        'plugin.Lms.TmpProblems',
        'plugin.Lms.UserMetas',
        'plugin.Lms.Challengetags',
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
