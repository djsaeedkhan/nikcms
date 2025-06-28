<?php
declare(strict_types=1);

namespace Lms\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * LmsUserprofilesFixture
 */
class LmsUserprofilesFixture extends TestFixture
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
            ],
        ];
        parent::init();
    }
}
