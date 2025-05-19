<?php
namespace Lms\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Lms\Model\Table\LmsCouponsTable;

/**
 * Lms\Model\Table\LmsCouponsTable Test Case
 */
class LmsCouponsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Lms\Model\Table\LmsCouponsTable
     */
    public $LmsCoupons;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.Lms.LmsCoupons',
        'plugin.Lms.LmsFactors',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('LmsCoupons') ? [] : ['className' => LmsCouponsTable::class];
        $this->LmsCoupons = TableRegistry::getTableLocator()->get('LmsCoupons', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->LmsCoupons);

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
}
