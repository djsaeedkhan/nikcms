<?php
declare(strict_types=1);

namespace Challenge\Test\TestCase\Model\Table;

use Cake\TestSuite\TestCase;
use Challenge\Model\Table\ChallengefollowersTable;

/**
 * Challenge\Model\Table\ChallengefollowersTable Test Case
 */
class ChallengefollowersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Challenge\Model\Table\ChallengefollowersTable
     */
    protected $Challengefollowers;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'plugin.Challenge.Challengefollowers',
        'plugin.Challenge.Challenges',
        'plugin.Challenge.Users',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Challengefollowers') ? [] : ['className' => ChallengefollowersTable::class];
        $this->Challengefollowers = $this->getTableLocator()->get('Challengefollowers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Challengefollowers);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \Challenge\Model\Table\ChallengefollowersTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test beforeSave method
     *
     * @return void
     * @uses \Challenge\Model\Table\ChallengefollowersTable::beforeSave()
     */
    public function testBeforeSave(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \Challenge\Model\Table\ChallengefollowersTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
