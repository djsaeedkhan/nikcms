<?php
declare(strict_types=1);

namespace Ticketing\Test\TestCase\Model\Table;

use Cake\TestSuite\TestCase;
use Ticketing\Model\Table\TicketauditsTable;

/**
 * Ticketing\Model\Table\TicketauditsTable Test Case
 */
class TicketauditsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Ticketing\Model\Table\TicketauditsTable
     */
    protected $Ticketaudits;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'plugin.Ticketing.Ticketaudits',
        'plugin.Ticketing.Users',
        'plugin.Ticketing.Tickets',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Ticketaudits') ? [] : ['className' => TicketauditsTable::class];
        $this->Ticketaudits = $this->getTableLocator()->get('Ticketaudits', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Ticketaudits);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \Ticketing\Model\Table\TicketauditsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \Ticketing\Model\Table\TicketauditsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
