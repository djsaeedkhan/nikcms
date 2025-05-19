<?php
namespace Challenge\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Challenge\Model\Table\ChallengetopicsTable;

/**
 * Challenge\Model\Table\ChallengetopicsTable Test Case
 */
class ChallengetopicsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Challenge\Model\Table\ChallengetopicsTable
     */
    public $Challengetopics;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.Challenge.Challengetopics',
        'plugin.Challenge.Challenges',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Challengetopics') ? [] : ['className' => ChallengetopicsTable::class];
        $this->Challengetopics = TableRegistry::getTableLocator()->get('Challengetopics', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Challengetopics);

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
