<?php
declare(strict_types=1);

namespace Sms\Test\TestCase\Model\Table;

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
    protected $SmsValidations;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'plugin.Sms.SmsValidations',
        'plugin.Sms.Users',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('SmsValidations') ? [] : ['className' => SmsValidationsTable::class];
        $this->SmsValidations = $this->getTableLocator()->get('SmsValidations', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->SmsValidations);

        parent::tearDown();
    }

    /**
     * Test beforeSave method
     *
     * @return void
     * @uses \Sms\Model\Table\SmsValidationsTable::beforeSave()
     */
    public function testBeforeSave(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \Sms\Model\Table\SmsValidationsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \Sms\Model\Table\SmsValidationsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
