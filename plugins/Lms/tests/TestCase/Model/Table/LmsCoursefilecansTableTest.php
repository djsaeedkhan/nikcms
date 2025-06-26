<?php
declare(strict_types=1);

namespace Lms\Test\TestCase\Model\Table;

use Cake\TestSuite\TestCase;
use Lms\Model\Table\LmsCoursefilecansTable;

/**
 * Lms\Model\Table\LmsCoursefilecansTable Test Case
 */
class LmsCoursefilecansTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Lms\Model\Table\LmsCoursefilecansTable
     */
    protected $LmsCoursefilecans;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'plugin.Lms.LmsCoursefilecans',
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
        $config = $this->getTableLocator()->exists('LmsCoursefilecans') ? [] : ['className' => LmsCoursefilecansTable::class];
        $this->LmsCoursefilecans = $this->getTableLocator()->get('LmsCoursefilecans', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->LmsCoursefilecans);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \Lms\Model\Table\LmsCoursefilecansTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \Lms\Model\Table\LmsCoursefilecansTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test beforeSave method
     *
     * @return void
     * @uses \Lms\Model\Table\LmsCoursefilecansTable::beforeSave()
     */
    public function testBeforeSave(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
