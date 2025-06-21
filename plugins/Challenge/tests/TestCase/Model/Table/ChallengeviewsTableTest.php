<?php
declare(strict_types=1);

namespace Challenge\Test\TestCase\Model\Table;

use Cake\TestSuite\TestCase;
use Challenge\Model\Table\ChallengeviewsTable;

/**
 * Challenge\Model\Table\ChallengeviewsTable Test Case
 */
class ChallengeviewsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Challenge\Model\Table\ChallengeviewsTable
     */
    protected $Challengeviews;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'plugin.Challenge.Challengeviews',
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
        $config = TableRegistry::getTableLocator()->exists('Challengeviews') ? [] : ['className' => ChallengeviewsTable::class];
        $this->Challengeviews = TableRegistry::getTableLocator()->get('Challengeviews', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Challengeviews);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \Challenge\Model\Table\ChallengeviewsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \Challenge\Model\Table\ChallengeviewsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
