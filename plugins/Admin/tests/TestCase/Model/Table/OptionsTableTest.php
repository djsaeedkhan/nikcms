<?php
declare(strict_types=1);

namespace Admin\Test\TestCase\Model\Table;

use Admin\Model\Table\OptionsTable;
use Cake\TestSuite\TestCase;

/**
 * Admin\Model\Table\OptionsTable Test Case
 */
class OptionsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Admin\Model\Table\OptionsTable
     */
    protected $Options;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'plugin.Admin.Options',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Options') ? [] : ['className' => OptionsTable::class];
        $this->Options = TableRegistry::getTableLocator()->get('Options', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Options);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \Admin\Model\Table\OptionsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
