<?php
declare(strict_types=1);

namespace Challenge\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ChallengefollowersFixture
 */
class ChallengefollowersFixture extends TestFixture
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
                'challenge_id' => 1,
                'user_id' => 1,
                'created' => '2025-06-03',
            ],
        ];
        parent::init();
    }
}
