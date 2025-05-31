<?php
declare(strict_types=1);

namespace Admin\Test\Fixture;

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
                'created' => '2025-05-31 18:04:27',
            ],
        ];
        parent::init();
    }
}
