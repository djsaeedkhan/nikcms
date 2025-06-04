<?php
declare(strict_types=1);

namespace Userslogs\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UsersFixture
 */
class UsersFixture extends TestFixture
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
                'username' => 'Lorem ipsum dolor sit amet',
                'password' => 'Lorem ipsum dolor sit amet',
                'family' => 'Lorem ipsum dolor sit amet',
                'email' => 'Lorem ipsum dolor sit amet',
                'phone' => 'Lorem ipsum d',
                'role_id' => 'Lorem ipsum dolor ',
                'enable' => 1,
                'token' => 'Lorem ipsum dolor sit amet',
                'created' => '2025-06-04 18:42:30',
                'modified' => '2025-06-04 18:42:30',
                'expired' => '2025-06-04 18:42:30',
            ],
        ];
        parent::init();
    }
}
