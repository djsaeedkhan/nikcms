<?php
declare(strict_types=1);

namespace Sss\Test\TestCase\Model\Table;

use Cake\TestSuite\TestCase;
use Sss\Model\Table\UsersTable;

/**
 * Sss\Model\Table\UsersTable Test Case
 */
class UsersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Sss\Model\Table\UsersTable
     */
    protected $Users;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'plugin.Sss.Users',
        'plugin.Sss.Roles',
        'plugin.Sss.Challengeblueticks',
        'plugin.Sss.Challengefollowers',
        'plugin.Sss.Challengeforums',
        'plugin.Sss.Challengeqanswers',
        'plugin.Sss.Challenges',
        'plugin.Sss.Challengeuserforms',
        'plugin.Sss.Challengeuserprofiles',
        'plugin.Sss.Comments',
        'plugin.Sss.FormbuilderDatas',
        'plugin.Sss.LmsCertificates',
        'plugin.Sss.LmsCoursefilecans',
        'plugin.Sss.LmsCourses',
        'plugin.Sss.LmsCoursesessions',
        'plugin.Sss.LmsCourseusers',
        'plugin.Sss.LmsExamresultlists',
        'plugin.Sss.LmsExamresults',
        'plugin.Sss.LmsExams',
        'plugin.Sss.LmsExamusers',
        'plugin.Sss.LmsFactors',
        'plugin.Sss.LmsPayments',
        'plugin.Sss.LmsUserfactors',
        'plugin.Sss.LmsUsernotes',
        'plugin.Sss.LmsUserprofiles',
        'plugin.Sss.Logs',
        'plugin.Sss.PollVotes',
        'plugin.Sss.Posts',
        'plugin.Sss.Profiles',
        'plugin.Sss.ShopAddresses',
        'plugin.Sss.ShopFavorites',
        'plugin.Sss.ShopLogesticusers',
        'plugin.Sss.ShopOrderlogesticlogs',
        'plugin.Sss.ShopOrderlogestics',
        'plugin.Sss.ShopOrderlogs',
        'plugin.Sss.ShopOrderrefunds',
        'plugin.Sss.ShopOrders',
        'plugin.Sss.ShopOrdershippings',
        'plugin.Sss.ShopOrdertexts',
        'plugin.Sss.ShopOrdertokens',
        'plugin.Sss.ShopPayments',
        'plugin.Sss.ShopProfiles',
        'plugin.Sss.ShopUseraddresses',
        'plugin.Sss.SmsValidations',
        'plugin.Sss.Ticketaudits',
        'plugin.Sss.Ticketcomments',
        'plugin.Sss.Tickets',
        'plugin.Sss.TmpChallengeforms',
        'plugin.Sss.TmpMembers',
        'plugin.Sss.TmpPersonlikes',
        'plugin.Sss.TmpPersons',
        'plugin.Sss.TmpProblemforms',
        'plugin.Sss.TmpProblems',
        'plugin.Sss.UserMetas',
        'plugin.Sss.Challengetags',
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
     * @uses \Sss\Model\Table\UsersTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \Sss\Model\Table\UsersTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
