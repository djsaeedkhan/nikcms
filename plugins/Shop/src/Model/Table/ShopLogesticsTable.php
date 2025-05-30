<?php
namespace Shop\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ShopLogestics Model
 *
 * @property \Shop\Model\Table\ShopLogesticlistsTable&\Cake\ORM\Association\BelongsTo $ShopLogesticlists
 * @property \Shop\Model\Table\ShopLogesticusersTable&\Cake\ORM\Association\HasMany $ShopLogesticusers
 * @property \Shop\Model\Table\ShopOrderlogesticlogsTable&\Cake\ORM\Association\HasMany $ShopOrderlogesticlogs
 * @property \Shop\Model\Table\ShopOrderlogesticsTable&\Cake\ORM\Association\HasMany $ShopOrderlogestics
 *
 * @method \Shop\Model\Entity\ShopLogestic get($primaryKey, $options = [])
 * @method \Shop\Model\Entity\ShopLogestic newEmptyEntity($data = null, array $options = [])
 * @method \Shop\Model\Entity\ShopLogestic[] newEntities(array $data, array $options = [])
 * @method \Shop\Model\Entity\ShopLogestic|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Shop\Model\Entity\ShopLogestic saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Shop\Model\Entity\ShopLogestic patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Shop\Model\Entity\ShopLogestic[] patchEntities($entities, array $data, array $options = [])
 * @method \Shop\Model\Entity\ShopLogestic findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ShopLogesticsTable extends Table
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

        $this->setTable('shop_logestics');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('ShopLogesticlists', [
            'foreignKey' => 'shop_logesticlist_id',
            'joinType' => 'INNER',
            'className' => 'Shop.ShopLogesticlists',
        ]);
        $this->hasMany('ShopLogesticusers', [
            'foreignKey' => 'shop_logestic_id',
            'className' => 'Shop.ShopLogesticusers',
        ]);
        $this->hasMany('ShopOrderlogesticlogs', [
            'foreignKey' => 'shop_logestic_id',
            'className' => 'Shop.ShopOrderlogesticlogs',
        ]);
        $this->hasMany('ShopOrderlogestics', [
            'foreignKey' => 'shop_logestic_id',
            'className' => 'Shop.ShopOrderlogestics',
        ]);
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

        $validator
            ->scalar('title')
            ->maxLength('title', 200)
            ->requirePresence('title', 'create')
            ->notEmptyString('title');

        $validator
            ->scalar('descr')
            ->maxLength('descr', 5000)
            ->allowEmptyString('descr');

        $validator
            ->scalar('address')
            ->maxLength('address', 1000)
            ->allowEmptyString('address');

        $validator
            ->scalar('image')
            ->maxLength('image', 100)
            ->allowEmptyFile('image');

        $validator
            ->scalar('phone1')
            ->maxLength('phone1', 20)
            ->allowEmptyString('phone1');

        $validator
            ->scalar('phone2')
            ->maxLength('phone2', 20)
            ->allowEmptyString('phone2');

        $validator
            ->scalar('mobile1')
            ->maxLength('mobile1', 20)
            ->allowEmptyString('mobile1');

        $validator
            ->scalar('mobile2')
            ->maxLength('mobile2', 20)
            ->allowEmptyString('mobile2');

        $validator
            ->scalar('level')
            ->maxLength('level', 100)
            ->allowEmptyString('level');

        $validator
            ->boolean('enable')
            ->notEmptyString('enable');

        $validator
            ->scalar('map_url')
            ->maxLength('map_url', 1000)
            ->allowEmptyString('map_url');

        $validator
            ->scalar('location')
            ->maxLength('location', 1000)
            ->allowEmptyString('location');

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
        $rules->add($rules->existsIn(['shop_logesticlist_id'], 'ShopLogesticlists'));

        return $rules;
    }
}
