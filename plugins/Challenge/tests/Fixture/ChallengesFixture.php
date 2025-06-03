<?php
declare(strict_types=1);

namespace Challenge\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ChallengesFixture
 */
class ChallengesFixture extends TestFixture
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
                'slug' => 'Lorem ipsum dolor sit amet',
                'descr' => 'Lorem ipsum dolor sit amet',
                'img' => 'Lorem ipsum dolor sit amet',
                'img1' => 'Lorem ipsum dolor sit amet',
                'img2' => 'Lorem ipsum dolor sit amet',
                'challengestatus_id' => 1,
                'start_date' => 'Lorem ipsu',
                'end_date' => 'Lorem ipsu',
                'user_id' => 1,
                'enable' => 1,
                'price' => 'Lorem ipsum dolor sit amet',
                'created' => '2025-06-03 06:26:27',
            ],
        ];
        parent::init();
    }
}
