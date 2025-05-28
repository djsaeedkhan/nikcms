<?php
namespace Shop\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ShopAttributelists Model
 *
 * @property \Shop\Model\Table\ShopAttributesTable&\Cake\ORM\Association\BelongsTo $ShopAttributes
 *
 * @method \Shop\Model\Entity\ShopAttributelist get($primaryKey, $options = [])
 * @method \Shop\Model\Entity\ShopAttributelist newEmptyEntity(($data = null, array $options = [])
 * @method \Shop\Model\Entity\ShopAttributelist[] newEntities(array $data, array $options = [])
 * @method \Shop\Model\Entity\ShopAttributelist|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Shop\Model\Entity\ShopAttributelist saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Shop\Model\Entity\ShopAttributelist patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Shop\Model\Entity\ShopAttributelist[] patchEntities($entities, array $data, array $options = [])
 * @method \Shop\Model\Entity\ShopAttributelist findOrCreate($search, callable $callback = null, $options = [])
 */
class ShopAttributelistsTable extends Table
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

        $this->setTable('shop_attributelists');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->belongsTo('ShopAttributes', [
            'foreignKey' => 'shop_attribute_id',
            'joinType' => 'INNER',
            'className' => 'Shop.ShopAttributes',
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
            ->scalar('value')
            ->maxLength('value', 200)
            ->requirePresence('value', 'create')
            ->notEmptyString('value');

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
        $rules->add($rules->existsIn(['shop_attribute_id'], 'ShopAttributes'));

        return $rules;
    }
}
