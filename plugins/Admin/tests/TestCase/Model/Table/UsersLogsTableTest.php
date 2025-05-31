<?php
declare(strict_types=1);

namespace Admin\Test\TestCase\Model\Table;

use Admin\Model\Table\UsersLogsTable;
use Cake\TestSuite\TestCase;

/**
 * Admin\Model\Table\UsersLogsTable Test Case
 */
class UsersLogsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Admin\Model\Table\UsersLogsTable
     */
    protected $UsersLogs;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'plugin.Admin.UsersLogs',
        'plugin.Admin.Users',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('UsersLogs') ? [] : ['className' => UsersLogsTable::class];
        $this->UsersLogs = $this->getTableLocator()->get('UsersLogs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->UsersLogs);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \Admin\Model\Table\UsersLogsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \Admin\Model\Table\UsersLogsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
