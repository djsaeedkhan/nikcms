<?php
declare(strict_types=1);

namespace Challenge\Test\TestCase\View\Cell;

use Cake\TestSuite\TestCase;
use Challenge\View\Cell\HomeCell;

/**
 * Challenge\View\Cell\HomeCell Test Case
 */
class HomeCellTest extends TestCase
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
     * @var \Challenge\View\Cell\HomeCell
     */
    protected $Home;

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
        $this->Home = new HomeCell($this->request, $this->response);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Home);

        parent::tearDown();
    }

    /**
     * Test display method
     *
     * @return void
     * @uses \Challenge\View\Cell\HomeCell::display()
     */
    public function testDisplay(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
