<?php
declare(strict_types=1);

namespace SSS\Test\TestCase\Model\Table;

use Cake\TestSuite\TestCase;
use SSS\Model\Table\UsersTable;

/**
 * SSS\Model\Table\UsersTable Test Case
 */
class UsersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \SSS\Model\Table\UsersTable
     */
    protected $Users;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'plugin.SSS.Users',
        'plugin.SSS.Roles',
        'plugin.SSS.Challengeblueticks',
        'plugin.SSS.Challengefollowers',
        'plugin.SSS.Challengeforums',
        'plugin.SSS.Challengeqanswers',
        'plugin.SSS.Challenges',
        'plugin.SSS.Challengeuserforms',
        'plugin.SSS.Challengeuserprofiles',
        'plugin.SSS.Comments',
        'plugin.SSS.FormbuilderDatas',
        'plugin.SSS.LmsCertificates',
        'plugin.SSS.LmsCoursefilecans',
        'plugin.SSS.LmsCourses',
        'plugin.SSS.LmsCoursesessions',
        'plugin.SSS.LmsCourseusers',
        'plugin.SSS.LmsExamresultlists',
        'plugin.SSS.LmsExamresults',
        'plugin.SSS.LmsExams',
        'plugin.SSS.LmsExamusers',
        'plugin.SSS.LmsFactors',
        'plugin.SSS.LmsPayments',
        'plugin.SSS.LmsUserfactors',
        'plugin.SSS.LmsUsernotes',
        'plugin.SSS.LmsUserprofiles',
        'plugin.SSS.Logs',
        'plugin.SSS.PollVotes',
        'plugin.SSS.Posts',
        'plugin.SSS.Profiles',
        'plugin.SSS.ShopAddresses',
        'plugin.SSS.ShopFavorites',
        'plugin.SSS.ShopLogesticusers',
        'plugin.SSS.ShopOrderlogesticlogs',
        'plugin.SSS.ShopOrderlogestics',
        'plugin.SSS.ShopOrderlogs',
        'plugin.SSS.ShopOrderrefunds',
        'plugin.SSS.ShopOrders',
        'plugin.SSS.ShopOrdershippings',
        'plugin.SSS.ShopOrdertexts',
        'plugin.SSS.ShopOrdertokens',
        'plugin.SSS.ShopPayments',
        'plugin.SSS.ShopProfiles',
        'plugin.SSS.ShopUseraddresses',
        'plugin.SSS.SmsValidations',
        'plugin.SSS.Ticketaudits',
        'plugin.SSS.Ticketcomments',
        'plugin.SSS.Tickets',
        'plugin.SSS.TmpChallengeforms',
        'plugin.SSS.TmpMembers',
        'plugin.SSS.TmpPersonlikes',
        'plugin.SSS.TmpPersons',
        'plugin.SSS.TmpProblemforms',
        'plugin.SSS.TmpProblems',
        'plugin.SSS.UserMetas',
        'plugin.SSS.Challengetags',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Users') ? [] : ['className' => UsersTable::class];
        $this->Users = $this->getTableLocator()->get('Users', $config);
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
     * Test validationDefault method
     *
     * @return void
     * @uses \SSS\Model\Table\UsersTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \SSS\Model\Table\UsersTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
