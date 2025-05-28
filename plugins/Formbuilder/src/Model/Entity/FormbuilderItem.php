<?php
namespace Formbuilder\Model\Entity;

use Cake\ORM\Entity;

/**
 * FormbuilderItem Entity
 *
 * @property int $id
 * @property int $formbuilder_id
 * @property string|null $data
 * @property string|null $form_data
 * @property string|null $form_html
 * @property string|null $css
 * @property string|null $logo
 * @property string|null $uinfo
 * @property string|null $footer
 * @property string|null $smstext
 * @property string|null $submit
 *
 * @property \Formbuilder\Model\Entity\Formbuilder $formbuilder
 */
class FormbuilderItem extends Entity
{
    /**
     * Fields that can be mass assigned using newEmptyEntity(() or patchEntity().
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
        'form_data' => true,
        'form_html' => true,
        'css' => true,
        'logo' => true,
        'uinfo' => true,
        'footer' => true,
        'smstext' => true,
        'submit' => true,
        'formbuilder' => true,
    ];
}
