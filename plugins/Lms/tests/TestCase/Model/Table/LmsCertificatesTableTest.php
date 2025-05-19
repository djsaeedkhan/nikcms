<?php
namespace Lms\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Lms\Model\Table\LmsCertificatesTable;

/**
 * Lms\Model\Table\LmsCertificatesTable Test Case
 */
class LmsCertificatesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Lms\Model\Table\LmsCertificatesTable
     */
    public $LmsCertificates;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.Lms.LmsCertificates',
        'plugin.Lms.Users',
        'plugin.Lms.LmsCourses',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('LmsCertificates') ? [] : ['className' => LmsCertificatesTable::class];
        $this->LmsCertificates = TableRegistry::getTableLocator()->get('LmsCertificates', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->LmsCertificates);

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
