<?php
namespace Sms\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Sms\Model\Table\SmsValidationsTable;

/**
 * Sms\Model\Table\SmsValidationsTable Test Case
 */
class SmsValidationsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Sms\Model\Table\SmsValidationsTable
     */
    public $SmsValidations;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.Sms.SmsValidations',
        'plugin.Sms.Users',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('SmsValidations') ? [] : ['className' => SmsValidationsTable::class];
        $this->SmsValidations = TableRegistry::getTableLocator()->get('SmsValidations', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->SmsValidations);

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
