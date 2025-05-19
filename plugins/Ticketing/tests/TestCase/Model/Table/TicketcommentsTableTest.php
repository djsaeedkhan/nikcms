<?php
namespace Ticketing\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Ticketing\Model\Table\TicketcommentsTable;

/**
 * Ticketing\Model\Table\TicketcommentsTable Test Case
 */
class TicketcommentsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Ticketing\Model\Table\TicketcommentsTable
     */
    public $Ticketcomments;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.Ticketing.Ticketcomments',
        'plugin.Ticketing.Users',
        'plugin.Ticketing.Tickets',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Ticketcomments') ? [] : ['className' => TicketcommentsTable::class];
        $this->Ticketcomments = TableRegistry::getTableLocator()->get('Ticketcomments', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Ticketcomments);

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
