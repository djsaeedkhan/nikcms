<?php
namespace Formbuilder\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Formbuilder\Model\Table\FormbuilderItemsTable;

/**
 * Formbuilder\Model\Table\FormbuilderItemsTable Test Case
 */
class FormbuilderItemsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Formbuilder\Model\Table\FormbuilderItemsTable
     */
    public $FormbuilderItems;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.Formbuilder.FormbuilderItems',
        'plugin.Formbuilder.Formbuilders',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('FormbuilderItems') ? [] : ['className' => FormbuilderItemsTable::class];
        $this->FormbuilderItems = TableRegistry::getTableLocator()->get('FormbuilderItems', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->FormbuilderItems);

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

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
