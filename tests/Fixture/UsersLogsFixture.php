<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UsersLogsFixture
 */
class UsersLogsFixture extends TestFixture
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
                'user_id' => 1,
                'username' => 'Lorem ipsum dolor sit amet',
                'types' => 1,
                'created' => '2025-05-28 13:16:43',
            ],
        ];
        parent::init();
    }
}
