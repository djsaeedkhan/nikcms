<?php
declare(strict_types=1);

namespace Website\Test\TestCase\Controller\Component;

use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;
use Website\Controller\Component\AliComponent;

/**
 * Website\Controller\Component\AliComponent Test Case
 */
class AliComponentTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Website\Controller\Component\AliComponent
     */
    protected $Ali;

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->Ali = new AliComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Ali);

        parent::tearDown();
    }
}
