<?php
declare(strict_types=1);

namespace Admin\Test\TestCase\Model\Table;

use Admin\Model\Table\UserMetasTable;
use Cake\TestSuite\TestCase;

/**
 * Admin\Model\Table\UserMetasTable Test Case
 */
class UserMetasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Admin\Model\Table\UserMetasTable
     */
    protected $UserMetas;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'plugin.Admin.UserMetas',
        'plugin.Admin.Users',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('UserMetas') ? [] : ['className' => UserMetasTable::class];
        $this->UserMetas = TableRegistry::getTableLocator()->get('UserMetas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->UserMetas);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \Admin\Model\Table\UserMetasTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \Admin\Model\Table\UserMetasTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test beforeSave method
     *
     * @return void
     * @uses \Admin\Model\Table\UserMetasTable::beforeSave()
     */
    public function testBeforeSave(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
