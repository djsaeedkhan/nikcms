<?php
namespace Admin\Model\Entity;

use Cake\ORM\Entity;

/**
 * PostsI18n Entity
 *
 * @property int $id
 * @property string $locale
 * @property string $model
 * @property int $foreign_key
 * @property string $field
 * @property string|null $content
 */
class PostsI18n extends Entity
{
    /**
     * Fields that can be mass assigned using newEmptyEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'locale' => true,
        'model' => true,
        'foreign_key' => true,
        'field' => true,
        'content' => true,
    ];
}
