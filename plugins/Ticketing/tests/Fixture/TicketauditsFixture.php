<?php
declare(strict_types=1);

namespace Ticketing\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TicketauditsFixture
 */
class TicketauditsFixture extends TestFixture
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
                'operation' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'user_id' => 1,
                'ticket_id' => 1,
                'created' => '2025-06-04 17:02:11',
                'modified' => '2025-06-04 17:02:11',
            ],
        ];
        parent::init();
    }
}
