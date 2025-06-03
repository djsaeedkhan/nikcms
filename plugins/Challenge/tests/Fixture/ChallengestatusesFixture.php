<?php
declare(strict_types=1);

namespace Challenge\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ChallengestatusesFixture
 */
class ChallengestatusesFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'title' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
