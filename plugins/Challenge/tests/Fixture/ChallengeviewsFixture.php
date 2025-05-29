<?php
declare(strict_types=1);

namespace Challenge\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ChallengeviewsFixture
 */
class ChallengeviewsFixture extends TestFixture
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
                'views' => 1,
            ],
        ];
        parent::init();
    }
}
