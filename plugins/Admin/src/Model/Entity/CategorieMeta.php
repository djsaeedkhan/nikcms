<?php
declare(strict_types=1);

namespace Admin\Model\Entity;

use Cake\ORM\Entity;
use Admin\View\Helper\FuncHelper;

/**
 * CategorieMeta Entity
 *
 * @property int $id
 * @property int $categorie_id
 * @property string|null $meta_type
 * @property string|null $meta_key
 * @property string|null $meta_value
 *
 * @property \Admin\Model\Entity\Category $category
 */
class CategorieMeta extends Entity
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
        'categorie_id' => true,
        'meta_type' => true,
        'meta_key' => true,
        'meta_value' => true,
        'category' => true,
    ];
    protected $_virtual = ['meta_values'];
    protected function _getmetaValues()
    {
        $this->Func = new FuncHelper(new \Cake\View\View());

        return ($this->Func->is_serial($this->get('meta_value'))?
        unserialize($this->get('meta_value')):
        $this->get('meta_value'));
    }
}
