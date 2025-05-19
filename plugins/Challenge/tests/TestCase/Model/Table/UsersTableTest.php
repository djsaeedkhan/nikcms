<?php
namespace Challenge\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Challenge\Model\Table\UsersTable;

/**
 * Challenge\Model\Table\UsersTable Test Case
 */
class UsersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Challenge\Model\Table\UsersTable
     */
    public $Users;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.Challenge.Users',
        'plugin.Challenge.Roles',
        'plugin.Challenge.Challengeblueticks',
        'plugin.Challenge.Challengefollowers',
        'plugin.Challenge.Challengeforums',
        'plugin.Challenge.Challengeqanswers',
        'plugin.Challenge.Challenges',
        'plugin.Challenge.Challengeuserforms',
        'plugin.Challenge.Challengeuserprofiles',
        'plugin.Challenge.Comments',
        'plugin.Challenge.FormbuilderDatas',
        'plugin.Challenge.LmsCoursefilecans',
        'plugin.Challenge.LmsCourses',
        'plugin.Challenge.LmsCoursesessions',
        'plugin.Challenge.LmsCourseusers',
        'plugin.Challenge.LmsExamresultlists',
        'plugin.Challenge.LmsExamresults',
        'plugin.Challenge.LmsExams',
        'plugin.Challenge.LmsExamusers',
        'plugin.Challenge.LmsUsernotes',
        'plugin.Challenge.LmsUserprofiles',
        'plugin.Challenge.Logs',
        'plugin.Challenge.PollVotes',
        'plugin.Challenge.Posts',
        'plugin.Challenge.Profiles',
        'plugin.Challenge.ShopAddresses',
        'plugin.Challenge.ShopFavorites',
        'plugin.Challenge.ShopOrderlogs',
        'plugin.Challenge.ShopOrderrefunds',
        'plugin.Challenge.ShopOrders',
        'plugin.Challenge.ShopOrdershippings',
        'plugin.Challenge.ShopOrdertexts',
        'plugin.Challenge.ShopOrdertokens',
        'plugin.Challenge.ShopPayments',
        'plugin.Challenge.ShopProfiles',
        'plugin.Challenge.ShopUseraddresses',
        'plugin.Challenge.SmsValidations',
        'plugin.Challenge.Ticketaudits',
        'plugin.Challenge.Ticketcomments',
        'plugin.Challenge.Tickets',
        'plugin.Challenge.TmpChallengeforms',
        'plugin.Challenge.TmpMembers',
        'plugin.Challenge.TmpPersonlikes',
        'plugin.Challenge.TmpPersons',
        'plugin.Challenge.TmpProblemforms',
        'plugin.Challenge.TmpProblems',
        'plugin.Challenge.UserMetas',
        'plugin.Challenge.Challengetags',
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
