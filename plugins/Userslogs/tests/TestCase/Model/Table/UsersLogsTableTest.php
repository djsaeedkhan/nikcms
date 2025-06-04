<?php
declare(strict_types=1);

namespace Userslogs\Test\TestCase\Model\Table;

use Cake\TestSuite\TestCase;
use Userslogs\Model\Table\UsersLogsTable;

/**
 * Userslogs\Model\Table\UsersLogsTable Test Case
 */
class UsersLogsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Userslogs\Model\Table\UsersLogsTable
     */
    protected $UsersLogs;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'plugin.Userslogs.UsersLogs',
        'plugin.Userslogs.Users',
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
}
