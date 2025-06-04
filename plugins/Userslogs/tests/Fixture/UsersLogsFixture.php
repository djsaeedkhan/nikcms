<?php
declare(strict_types=1);

namespace Userslogs\Test\Fixture;

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
                'created' => '2025-06-04 18:43:10',
            ],
        ];
        parent::init();
    }
}
