<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UsersTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UsersTable Test Case
 */
class UsersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\UsersTable
     */
    protected $Users;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.Users',
        'app.Roles',
        'app.Comments',
        'app.FormbuilderDatas',
        'app.Logs',
        'app.PollVotes',
        'app.Posts',
        'app.Profiles',
        'app.ShopAddresses',
        'app.ShopFavorites',
        'app.ShopLogesticusers',
        'app.ShopOrderlogesticlogs',
        'app.ShopOrderlogestics',
        'app.ShopOrderlogs',
        'app.ShopOrderrefunds',
        'app.ShopOrders',
        'app.ShopOrdershippings',
        'app.ShopOrdertexts',
        'app.ShopOrdertokens',
        'app.ShopPayments',
        'app.ShopProfiles',
        'app.ShopUseraddresses',
        'app.SmsValidations',
        'app.UserMetas',
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
     * @uses \App\Model\Table\UsersTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\UsersTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
