<?php
namespace Shop\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ShopOrderattributes Model
 *
 * @property \Shop\Model\Table\ShopOrderproductsTable&\Cake\ORM\Association\BelongsTo $ShopOrderproducts
 * @property \Shop\Model\Table\ShopAttributesTable&\Cake\ORM\Association\BelongsTo $ShopAttributes
 * @property \Shop\Model\Table\ShopAttributelistsTable&\Cake\ORM\Association\BelongsTo $ShopAttributelists
 *
 * @method \Shop\Model\Entity\ShopOrderattribute get($primaryKey, $options = [])
 * @method \Shop\Model\Entity\ShopOrderattribute newEmptyEntity($data = null, array $options = [])
 * @method \Shop\Model\Entity\ShopOrderattribute[] newEntities(array $data, array $options = [])
 * @method \Shop\Model\Entity\ShopOrderattribute|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Shop\Model\Entity\ShopOrderattribute saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Shop\Model\Entity\ShopOrderattribute patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Shop\Model\Entity\ShopOrderattribute[] patchEntities($entities, array $data, array $options = [])
 * @method \Shop\Model\Entity\ShopOrderattribute findOrCreate($search, callable $callback = null, $options = [])
 */
class ShopOrderattributesTable extends Table
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

        $this->setTable('shop_orderattributes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('ShopOrderproducts', [
            'foreignKey' => 'shop_orderproduct_id',
            'joinType' => 'INNER',
            'className' => 'Shop.ShopOrderproducts',
        ]);
        $this->belongsTo('ShopAttributes', [
            'foreignKey' => 'shop_attribute_id',
            'joinType' => 'INNER',
            'className' => 'Shop.ShopAttributes',
        ]);
        $this->belongsTo('ShopAttributelists', [
            'foreignKey' => 'shop_attributelist_id',
            'joinType' => 'INNER',
            'className' => 'Shop.ShopAttributelists',
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
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['shop_orderproduct_id'], 'ShopOrderproducts'));
        $rules->add($rules->existsIn(['shop_attribute_id'], 'ShopAttributes'));
        $rules->add($rules->existsIn(['shop_attributelist_id'], 'ShopAttributelists'));

        return $rules;
    }
}
