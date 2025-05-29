<?php
namespace Shop\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ShopLogesticusers Model
 *
 * @property \Shop\Model\Table\ShopLogesticsTable&\Cake\ORM\Association\BelongsTo $ShopLogestics
 * @property \Shop\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \Shop\Model\Entity\ShopLogesticuser get($primaryKey, $options = [])
 * @method \Shop\Model\Entity\ShopLogesticuser newEmptyEntity(($data = null, array $options = [])
 * @method \Shop\Model\Entity\ShopLogesticuser[] newEntities(array $data, array $options = [])
 * @method \Shop\Model\Entity\ShopLogesticuser|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Shop\Model\Entity\ShopLogesticuser saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Shop\Model\Entity\ShopLogesticuser patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Shop\Model\Entity\ShopLogesticuser[] patchEntities($entities, array $data, array $options = [])
 * @method \Shop\Model\Entity\ShopLogesticuser findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ShopLogesticusersTable extends Table
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

        $this->setTable('shop_logesticusers');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('ShopLogestics', [
            'foreignKey' => 'shop_logestic_id',
            'joinType' => 'INNER',
            'className' => 'Shop.ShopLogestics',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
            'className' => 'Shop.Users',
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
        $rules->add($rules->existsIn(['shop_logestic_id'], 'ShopLogestics'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
