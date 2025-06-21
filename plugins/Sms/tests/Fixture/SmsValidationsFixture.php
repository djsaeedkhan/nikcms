<?php
declare(strict_types=1);

namespace Sms\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SmsValidationsFixture
 */
class SmsValidationsFixture extends TestFixture
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
                'mobile' => 'Lorem ips',
                'code' => 'Lorem ip',
                'status' => 1,
                'created' => '2025-06-21 09:39:05',
            ],
        ];
        parent::init();
    }
}
