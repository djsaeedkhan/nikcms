<?php
namespace Scheduler\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Scheduler\Model\Table\CronjobsTable;

/**
 * Scheduler\Model\Table\CronjobsTable Test Case
 */
class CronjobsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Scheduler\Model\Table\CronjobsTable
     */
    public $Cronjobs;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.Scheduler.Cronjobs',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Cronjobs') ? [] : ['className' => CronjobsTable::class];
        $this->Cronjobs = TableRegistry::getTableLocator()->get('Cronjobs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Cronjobs);

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
