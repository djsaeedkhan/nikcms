<?php
namespace Shop\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ShopParams Model
 *
 * @property \Shop\Model\Table\ShopParamlistsTable&\Cake\ORM\Association\HasMany $ShopParamlists
 *
 * @method \Shop\Model\Entity\ShopParam get($primaryKey, $options = [])
 * @method \Shop\Model\Entity\ShopParam newEntity($data = null, array $options = [])
 * @method \Shop\Model\Entity\ShopParam[] newEntities(array $data, array $options = [])
 * @method \Shop\Model\Entity\ShopParam|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Shop\Model\Entity\ShopParam saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Shop\Model\Entity\ShopParam patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Shop\Model\Entity\ShopParam[] patchEntities($entities, array $data, array $options = [])
 * @method \Shop\Model\Entity\ShopParam findOrCreate($search, callable $callback = null, $options = [])
 */
class ShopParamsTable extends Table
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

        $this->setTable('shop_params');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->hasMany('ShopParamlists', [
            'foreignKey' => 'shop_param_id',
            'className' => 'Shop.ShopParamlists',
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

        return $validator;
    }
}
