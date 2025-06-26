<?php
declare(strict_types=1);

namespace Lms\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * LmsCoursesFixture
 */
class LmsCoursesFixture extends TestFixture
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
                'lms_coursecategorie_id' => 1,
                'user_id' => 1,
                'text' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'textweb' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'image' => 'Lorem ipsum dolor sit amet',
                'date_start' => '2025-05-29 10:57:48',
                'date_end' => '2025-05-29 10:57:48',
                'date_type' => 1,
                'price' => 1,
                'price_special' => 1,
                'price_renew' => 1,
                'show_in_list' => 1,
                'can_add' => 1,
                'can_renew' => 1,
                'renew_day' => 1,
                'total_time' => 'Lorem ipsum dolor sit amet',
                'enable' => 1,
                'priority' => 1,
                'options' => 'Lorem ipsum dolor sit amet',
                'created' => '2025-05-29 10:57:48',
            ],
        ];
        parent::init();
    }
}
