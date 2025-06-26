<?php
declare(strict_types=1);

namespace Lms\Model\Entity;

use Cake\ORM\Entity;

/**
 * UserMeta Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string $meta_type
 * @property string|null $meta_key
 * @property string|null $meta_value
 *
 * @property \Lms\Model\Entity\User $user
 */
class UserMeta extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected $_accessible = [
        'user_id' => true,
        'meta_type' => true,
        'meta_key' => true,
        'meta_value' => true,
        'user' => true,
    ];
}
