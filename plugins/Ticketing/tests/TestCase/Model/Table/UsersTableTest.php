<?php
namespace Ticketing\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Ticketing\Model\Table\UsersTable;

/**
 * Ticketing\Model\Table\UsersTable Test Case
 */
class UsersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Ticketing\Model\Table\UsersTable
     */
    public $Users;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.Ticketing.Users',
        'plugin.Ticketing.Roles',
        'plugin.Ticketing.Challengeblueticks',
        'plugin.Ticketing.Challengefollowers',
        'plugin.Ticketing.Challengeforums',
        'plugin.Ticketing.Challengeqanswers',
        'plugin.Ticketing.Challenges',
        'plugin.Ticketing.Challengeuserforms',
        'plugin.Ticketing.Challengeuserprofiles',
        'plugin.Ticketing.Comments',
        'plugin.Ticketing.FormbuilderDatas',
        'plugin.Ticketing.LmsCoursefilecans',
        'plugin.Ticketing.LmsCourses',
        'plugin.Ticketing.LmsCoursesessions',
        'plugin.Ticketing.LmsCourseusers',
        'plugin.Ticketing.LmsExamresultlists',
        'plugin.Ticketing.LmsExamresults',
        'plugin.Ticketing.LmsExams',
        'plugin.Ticketing.LmsExamusers',
        'plugin.Ticketing.LmsFactors',
        'plugin.Ticketing.LmsPayments',
        'plugin.Ticketing.LmsUserfactors',
        'plugin.Ticketing.LmsUsernotes',
        'plugin.Ticketing.LmsUserprofiles',
        'plugin.Ticketing.Logs',
        'plugin.Ticketing.PollVotes',
        'plugin.Ticketing.Posts',
        'plugin.Ticketing.Profiles',
        'plugin.Ticketing.ShopAddresses',
        'plugin.Ticketing.ShopFavorites',
        'plugin.Ticketing.ShopOrderlogs',
        'plugin.Ticketing.ShopOrderrefunds',
        'plugin.Ticketing.ShopOrders',
        'plugin.Ticketing.ShopOrdershippings',
        'plugin.Ticketing.ShopOrdertexts',
        'plugin.Ticketing.ShopOrdertokens',
        'plugin.Ticketing.ShopPayments',
        'plugin.Ticketing.ShopProfiles',
        'plugin.Ticketing.ShopUseraddresses',
        'plugin.Ticketing.SmsValidations',
        'plugin.Ticketing.Ticketaudits',
        'plugin.Ticketing.Ticketcomments',
        'plugin.Ticketing.Tickets',
        'plugin.Ticketing.TmpChallengeforms',
        'plugin.Ticketing.TmpMembers',
        'plugin.Ticketing.TmpPersonlikes',
        'plugin.Ticketing.TmpPersons',
        'plugin.Ticketing.TmpProblemforms',
        'plugin.Ticketing.TmpProblems',
        'plugin.Ticketing.UserMetas',
        'plugin.Ticketing.Challengetags',
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
