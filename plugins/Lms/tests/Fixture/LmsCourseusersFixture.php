<?php
declare(strict_types=1);

namespace Lms\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * LmsCourseusersFixture
 */
class LmsCourseusersFixture extends TestFixture
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
                'lms_course_id' => 1,
                'user_id' => 1,
                'status' => 1,
                'enable' => 1,
                'created' => '2025-05-29 10:55:08',
            ],
        ];
        parent::init();
    }
}
