<?php
declare(strict_types=1);

namespace Lms\Test\TestCase\Model\Table;

use Cake\TestSuite\TestCase;
use Lms\Model\Table\LmsCoursesTable;

/**
 * Lms\Model\Table\LmsCoursesTable Test Case
 */
class LmsCoursesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Lms\Model\Table\LmsCoursesTable
     */
    protected $LmsCourses;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'plugin.Lms.LmsCourses',
        'plugin.Lms.LmsCoursecategories',
        'plugin.Lms.Users',
        'plugin.Lms.LmsCertificates',
        'plugin.Lms.LmsCourseexams',
        'plugin.Lms.LmsCoursefilecans',
        'plugin.Lms.LmsCoursefiles',
        'plugin.Lms.LmsCourserelateds',
        'plugin.Lms.LmsCoursesessions',
        'plugin.Lms.LmsCourseusers',
        'plugin.Lms.LmsCourseweeks',
        'plugin.Lms.LmsUserfactors',
        'plugin.Lms.LmsUsernotes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('LmsCourses') ? [] : ['className' => LmsCoursesTable::class];
        $this->LmsCourses = TableRegistry::getTableLocator()->get('LmsCourses', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->LmsCourses);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \Lms\Model\Table\LmsCoursesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \Lms\Model\Table\LmsCoursesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
