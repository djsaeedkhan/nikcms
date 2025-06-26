<?php
declare(strict_types=1);

namespace Lms\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * LmsCoursefilecansFixture
 */
class LmsCoursefilecansFixture extends TestFixture
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
                'lms_course_id' => 1,
                'lms_coursefile_id' => 1,
                'enable' => 1,
                'types' => 1,
                'created' => '2025-06-26 15:36:00',
            ],
        ];
        parent::init();
    }
}
