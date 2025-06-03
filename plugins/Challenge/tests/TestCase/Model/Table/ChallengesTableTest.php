<?php
declare(strict_types=1);

namespace Challenge\Test\TestCase\Model\Table;

use Cake\TestSuite\TestCase;
use Challenge\Model\Table\ChallengesTable;

/**
 * Challenge\Model\Table\ChallengesTable Test Case
 */
class ChallengesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Challenge\Model\Table\ChallengesTable
     */
    protected $Challenges;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'plugin.Challenge.Challenges',
        'plugin.Challenge.Challengestatuses',
        'plugin.Challenge.Users',
        'plugin.Challenge.Challengefollowers',
        'plugin.Challenge.Challengeforums',
        'plugin.Challenge.Challengeforumtitles',
        'plugin.Challenge.Challengeimages',
        'plugin.Challenge.Challengemetas',
        'plugin.Challenge.Challengepartners',
        'plugin.Challenge.Challengerelateds',
        'plugin.Challenge.Challengetexts',
        'plugin.Challenge.Challengetimelines',
        'plugin.Challenge.Challengeuserforms',
        'plugin.Challenge.Challengeviews',
        'plugin.Challenge.Challengecats',
        'plugin.Challenge.Challengefields',
        'plugin.Challenge.Challengetags',
        'plugin.Challenge.Challengetopics',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Challenges') ? [] : ['className' => ChallengesTable::class];
        $this->Challenges = $this->getTableLocator()->get('Challenges', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Challenges);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \Challenge\Model\Table\ChallengesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \Challenge\Model\Table\ChallengesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
