<?php
declare(strict_types=1);

namespace Userslogs\Test\TestCase\Model\Table;

use Cake\TestSuite\TestCase;
use Userslogs\Model\Table\UsersTable;

/**
 * Userslogs\Model\Table\UsersTable Test Case
 */
class UsersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Userslogs\Model\Table\UsersTable
     */
    protected $Users;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'plugin.Userslogs.Users',
        'plugin.Userslogs.Roles',
        'plugin.Userslogs.Challengeblueticks',
        'plugin.Userslogs.Challengefollowers',
        'plugin.Userslogs.Challengeforums',
        'plugin.Userslogs.Challengeqanswers',
        'plugin.Userslogs.Challenges',
        'plugin.Userslogs.Challengeuserforms',
        'plugin.Userslogs.Challengeuserprofiles',
        'plugin.Userslogs.Comments',
        'plugin.Userslogs.FormbuilderDatas',
        'plugin.Userslogs.LmsCertificates',
        'plugin.Userslogs.LmsCoursefilecans',
        'plugin.Userslogs.LmsCourses',
        'plugin.Userslogs.LmsCoursesessions',
        'plugin.Userslogs.LmsCourseusers',
        'plugin.Userslogs.LmsExamresultlists',
        'plugin.Userslogs.LmsExamresults',
        'plugin.Userslogs.LmsExams',
        'plugin.Userslogs.LmsExamusers',
        'plugin.Userslogs.LmsFactors',
        'plugin.Userslogs.LmsPayments',
        'plugin.Userslogs.LmsUserfactors',
        'plugin.Userslogs.LmsUsernotes',
        'plugin.Userslogs.LmsUserprofiles',
        'plugin.Userslogs.Logs',
        'plugin.Userslogs.PollVotes',
        'plugin.Userslogs.Posts',
        'plugin.Userslogs.Profiles',
        'plugin.Userslogs.ShopAddresses',
        'plugin.Userslogs.ShopFavorites',
        'plugin.Userslogs.ShopLogesticusers',
        'plugin.Userslogs.ShopOrderlogesticlogs',
        'plugin.Userslogs.ShopOrderlogestics',
        'plugin.Userslogs.ShopOrderlogs',
        'plugin.Userslogs.ShopOrderrefunds',
        'plugin.Userslogs.ShopOrders',
        'plugin.Userslogs.ShopOrdershippings',
        'plugin.Userslogs.ShopOrdertexts',
        'plugin.Userslogs.ShopOrdertokens',
        'plugin.Userslogs.ShopPayments',
        'plugin.Userslogs.ShopProfiles',
        'plugin.Userslogs.ShopUseraddresses',
        'plugin.Userslogs.SmsValidations',
        'plugin.Userslogs.Ticketaudits',
        'plugin.Userslogs.Ticketcomments',
        'plugin.Userslogs.Tickets',
        'plugin.Userslogs.TmpChallengeforms',
        'plugin.Userslogs.TmpMembers',
        'plugin.Userslogs.TmpPersonlikes',
        'plugin.Userslogs.TmpPersons',
        'plugin.Userslogs.TmpProblemforms',
        'plugin.Userslogs.TmpProblems',
        'plugin.Userslogs.UserMetas',
        'plugin.Userslogs.Challengetags',
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
}
