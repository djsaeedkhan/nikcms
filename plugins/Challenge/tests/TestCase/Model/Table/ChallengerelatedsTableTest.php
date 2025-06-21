<?php
declare(strict_types=1);

namespace Challenge\Test\TestCase\Model\Table;

use Cake\TestSuite\TestCase;
use Challenge\Model\Table\ChallengerelatedsTable;

/**
 * Challenge\Model\Table\ChallengerelatedsTable Test Case
 */
class ChallengerelatedsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Challenge\Model\Table\ChallengerelatedsTable
     */
    protected $Challengerelateds;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'plugin.Challenge.Challengerelateds',
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
        $config = TableRegistry::getTableLocator()->exists('Challengerelateds') ? [] : ['className' => ChallengerelatedsTable::class];
        $this->Challengerelateds = TableRegistry::getTableLocator()->get('Challengerelateds', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Challengerelateds);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \Challenge\Model\Table\ChallengerelatedsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test beforeSave method
     *
     * @return void
     * @uses \Challenge\Model\Table\ChallengerelatedsTable::beforeSave()
     */
    public function testBeforeSave(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \Challenge\Model\Table\ChallengerelatedsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
