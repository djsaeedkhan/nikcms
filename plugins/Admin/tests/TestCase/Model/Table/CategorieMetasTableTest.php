<?php
declare(strict_types=1);

namespace Admin\Test\TestCase\Model\Table;

use Admin\Model\Table\CategorieMetasTable;
use Cake\TestSuite\TestCase;

/**
 * Admin\Model\Table\CategorieMetasTable Test Case
 */
class CategorieMetasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Admin\Model\Table\CategorieMetasTable
     */
    protected $CategorieMetas;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'plugin.Admin.CategorieMetas',
        'plugin.Admin.Categories',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('CategorieMetas') ? [] : ['className' => CategorieMetasTable::class];
        $this->CategorieMetas = TableRegistry::getTableLocator()->get('CategorieMetas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->CategorieMetas);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \Admin\Model\Table\CategorieMetasTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \Admin\Model\Table\CategorieMetasTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
