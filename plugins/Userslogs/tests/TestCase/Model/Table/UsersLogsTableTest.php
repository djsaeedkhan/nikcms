<?php
namespace UsersLogs\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use UsersLogs\Model\Table\UsersLogsTable;

/**
 * UsersLogs\Model\Table\UsersLogsTable Test Case
 */
class UsersLogsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \UsersLogs\Model\Table\UsersLogsTable
     */
    public $UsersLogs;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.UsersLogs.UsersLogs',
        'plugin.UsersLogs.Users',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('UsersLogs') ? [] : ['className' => UsersLogsTable::class];
        $this->UsersLogs = TableRegistry::getTableLocator()->get('UsersLogs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->UsersLogs);

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
