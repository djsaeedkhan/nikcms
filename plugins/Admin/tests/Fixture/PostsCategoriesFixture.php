<?php
declare(strict_types=1);

namespace Admin\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PostsCategoriesFixture
 */
class PostsCategoriesFixture extends TestFixture
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
                'post_id' => 1,
                'category_id' => 1,
            ],
        ];
        parent::init();
    }
}
