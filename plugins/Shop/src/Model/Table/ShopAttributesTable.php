<?php
namespace Shop\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ShopAttributes Model
 *
 * @property \Shop\Model\Table\ShopAttributelistsTable&\Cake\ORM\Association\HasMany $ShopAttributelists
 * @property \Shop\Model\Table\ShopOrderattributesTable&\Cake\ORM\Association\HasMany $ShopOrderattributes
 *
 * @method \Shop\Model\Entity\ShopAttribute get($primaryKey, $options = [])
 * @method \Shop\Model\Entity\ShopAttribute newEntity($data = null, array $options = [])
 * @method \Shop\Model\Entity\ShopAttribute[] newEntities(array $data, array $options = [])
 * @method \Shop\Model\Entity\ShopAttribute|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Shop\Model\Entity\ShopAttribute saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Shop\Model\Entity\ShopAttribute patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Shop\Model\Entity\ShopAttribute[] patchEntities($entities, array $data, array $options = [])
 * @method \Shop\Model\Entity\ShopAttribute findOrCreate($search, callable $callback = null, $options = [])
 */
class ShopAttributesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('shop_attributes');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->hasMany('ShopAttributelists', [
            'foreignKey' => 'shop_attribute_id',
            'className' => 'Shop.ShopAttributelists',
        ]);
        $this->hasMany('ShopOrderattributes', [
            'foreignKey' => 'shop_attribute_id',
            'className' => 'Shop.ShopOrderattributes',
        ]);
    }

    public function beforeSave($event){
        $entity = $event->getData('entity');
        $modified = $entity->getDirty();
        foreach((array) $modified as $v) {
            if(isset($entity->{$v}) and $entity->{$v} != null) {
                if(in_array($v,['created','modified'])) return true;
                if(is_array($entity->{$v})){
                    //$entity->{$v} = ($entity->{$v});
                }else{
                    $entity->{$v} = strip_tags($entity->{$v},'<img><p><a><b><br><strong><br /><hr><i><span><div><ul><li><table><tr><td><thead><tbody>');
                }
            }
        }
        return true;
    }
    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('title')
            ->maxLength('title', 100)
            ->requirePresence('title', 'create')
            ->notEmptyString('title');

        $validator
            ->allowEmptyString('types');

        return $validator;
    }
}
