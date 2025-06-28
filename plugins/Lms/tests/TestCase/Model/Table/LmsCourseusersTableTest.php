<?php
declare(strict_types=1);

namespace Lms\Test\TestCase\Model\Table;

use Cake\TestSuite\TestCase;
use Lms\Model\Table\LmsCourseusersTable;

/**
 * Lms\Model\Table\LmsCourseusersTable Test Case
 */
class LmsCourseusersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Lms\Model\Table\LmsCourseusersTable
     */
    protected $LmsCourseusers;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'plugin.Lms.LmsCourseusers',
        'plugin.Lms.LmsCourses',
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
        $config = TableRegistry::getTableLocator()->exists('LmsCourseusers') ? [] : ['className' => LmsCourseusersTable::class];
        $this->LmsCourseusers = TableRegistry::getTableLocator()->get('LmsCourseusers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->LmsCourseusers);

        parent::tearDown();
    }

    /**
     * Test beforeSave method
     *
     * @return void
     * @uses \Lms\Model\Table\LmsCourseusersTable::beforeSave()
     */
    public function testBeforeSave(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \Lms\Model\Table\LmsCourseusersTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \Lms\Model\Table\LmsCourseusersTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
