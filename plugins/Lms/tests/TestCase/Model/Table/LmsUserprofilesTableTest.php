<?php
declare(strict_types=1);

namespace Lms\Test\TestCase\Model\Table;

use Cake\TestSuite\TestCase;
use Lms\Model\Table\LmsUserprofilesTable;

/**
 * Lms\Model\Table\LmsUserprofilesTable Test Case
 */
class LmsUserprofilesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Lms\Model\Table\LmsUserprofilesTable
     */
    protected $LmsUserprofiles;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'plugin.Lms.LmsUserprofiles',
        'plugin.Lms.Users',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('LmsUserprofiles') ? [] : ['className' => LmsUserprofilesTable::class];
        $this->LmsUserprofiles = $this->getTableLocator()->get('LmsUserprofiles', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->LmsUserprofiles);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \Lms\Model\Table\LmsUserprofilesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \Lms\Model\Table\LmsUserprofilesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
