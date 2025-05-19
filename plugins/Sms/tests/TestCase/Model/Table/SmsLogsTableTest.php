<?php
namespace Sms\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Sms\Model\Table\SmsLogsTable;

/**
 * Sms\Model\Table\SmsLogsTable Test Case
 */
class SmsLogsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Sms\Model\Table\SmsLogsTable
     */
    public $SmsLogs;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.Sms.SmsLogs',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('SmsLogs') ? [] : ['className' => SmsLogsTable::class];
        $this->SmsLogs = TableRegistry::getTableLocator()->get('SmsLogs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->SmsLogs);

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
}
