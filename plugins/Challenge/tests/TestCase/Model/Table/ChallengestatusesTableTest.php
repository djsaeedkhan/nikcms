<?php
declare(strict_types=1);

namespace Challenge\Test\TestCase\Model\Table;

use Cake\TestSuite\TestCase;
use Challenge\Model\Table\ChallengestatusesTable;

/**
 * Challenge\Model\Table\ChallengestatusesTable Test Case
 */
class ChallengestatusesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Challenge\Model\Table\ChallengestatusesTable
     */
    protected $Challengestatuses;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'plugin.Challenge.Challengestatuses',
        'plugin.Challenge.Challenges',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Challengestatuses') ? [] : ['className' => ChallengestatusesTable::class];
        $this->Challengestatuses = $this->getTableLocator()->get('Challengestatuses', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Challengestatuses);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \Challenge\Model\Table\ChallengestatusesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
