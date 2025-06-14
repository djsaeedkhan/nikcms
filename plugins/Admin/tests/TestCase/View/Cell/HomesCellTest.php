<?php
declare(strict_types=1);

namespace Admin\Test\TestCase\View\Cell;

use Admin\View\Cell\HomesCell;
use Cake\TestSuite\TestCase;

/**
 * Admin\View\Cell\HomesCell Test Case
 */
class HomesCellTest extends TestCase
{
    /**
     * Request mock
     *
     * @var \Cake\Http\ServerRequest|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $request;

    /**
     * Response mock
     *
     * @var \Cake\Http\Response|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $response;

    /**
     * Test subject
     *
     * @var \Admin\View\Cell\HomesCell
     */
    protected $Homes;

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->request = $this->getMockBuilder('Cake\Http\ServerRequest')->getMock();
        $this->response = $this->getMockBuilder('Cake\Http\Response')->getMock();
        $this->Homes = new HomesCell($this->request, $this->response);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Homes);

        parent::tearDown();
    }

    /**
     * Test display method
     *
     * @return void
     * @uses \Admin\View\Cell\HomesCell::display()
     */
    public function testDisplay(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
