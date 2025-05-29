<?php
namespace Formbuilder\Model\Entity;

use Cake\ORM\Entity;

/**
 * FormbuilderData Entity
 *
 * @property int $id
 * @property int|null $formbuilder_id
 * @property string|null $data
 * @property string|null $field
 * @property string|null $ips
 * @property int|null $user_id
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \Formbuilder\Model\Entity\Formbuilder $formbuilder
 * @property \Formbuilder\Model\Entity\User $user
 */
class FormbuilderData extends Entity
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
        'formbuilder_id' => true,
        'data' => true,
        'field' => true,
        'ips' => true,
        'user_id' => true,
        'created' => true,
        'formbuilder' => true,
        'user' => true,
    ];
}
