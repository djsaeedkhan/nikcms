<?php
declare(strict_types=1);

namespace Challenge\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Challenge\Controller\ChallengestatusesController;

/**
 * Challenge\Controller\ChallengestatusesController Test Case
 *
 * @uses \Challenge\Controller\ChallengestatusesController
 */
class ChallengestatusesControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'plugin.Challenge.Challengestatuses',
    ];

    /**
     * Test index method
     *
     * @return void
     * @uses \Challenge\Controller\ChallengestatusesController::index()
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     * @uses \Challenge\Controller\ChallengestatusesController::view()
     */
    public function testView(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \Challenge\Controller\ChallengestatusesController::add()
     */
    public function testAdd(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \Challenge\Controller\ChallengestatusesController::edit()
     */
    public function testEdit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \Challenge\Controller\ChallengestatusesController::delete()
     */
    public function testDelete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
