<?php
namespace Shop\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ShopLogesticlists Model
 *
 * @property \Shop\Model\Table\ShopLogesticsTable&\Cake\ORM\Association\HasMany $ShopLogestics
 *
 * @method \Shop\Model\Entity\ShopLogesticlist get($primaryKey, $options = [])
 * @method \Shop\Model\Entity\ShopLogesticlist newEntity($data = null, array $options = [])
 * @method \Shop\Model\Entity\ShopLogesticlist[] newEntities(array $data, array $options = [])
 * @method \Shop\Model\Entity\ShopLogesticlist|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Shop\Model\Entity\ShopLogesticlist saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Shop\Model\Entity\ShopLogesticlist patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Shop\Model\Entity\ShopLogesticlist[] patchEntities($entities, array $data, array $options = [])
 * @method \Shop\Model\Entity\ShopLogesticlist findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ShopLogesticlistsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('shop_logesticlists');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('ShopLogestics', [
            'foreignKey' => 'shop_logesticlist_id',
            'className' => 'Shop.ShopLogestics',
        ]);
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
            ->boolean('enable')
            ->notEmptyString('enable');

        return $validator;
    }
}
