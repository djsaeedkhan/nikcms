<?php
declare(strict_types=1);

namespace Lms\Test\TestCase\Model\Table;

use Cake\TestSuite\TestCase;
use Lms\Model\Table\LmsUsernotesTable;

/**
 * Lms\Model\Table\LmsUsernotesTable Test Case
 */
class LmsUsernotesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Lms\Model\Table\LmsUsernotesTable
     */
    protected $LmsUsernotes;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'plugin.Lms.LmsUsernotes',
        'plugin.Lms.Users',
        'plugin.Lms.LmsCourses',
        'plugin.Lms.LmsCoursefiles',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('LmsUsernotes') ? [] : ['className' => LmsUsernotesTable::class];
        $this->LmsUsernotes = $this->getTableLocator()->get('LmsUsernotes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->LmsUsernotes);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \Lms\Model\Table\LmsUsernotesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \Lms\Model\Table\LmsUsernotesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
