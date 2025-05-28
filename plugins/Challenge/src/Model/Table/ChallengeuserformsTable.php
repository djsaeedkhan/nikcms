<?php
namespace Challenge\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Challengeuserforms Model
 *
 * @property \Challenge\Model\Table\ChallengesTable&\Cake\ORM\Association\BelongsTo $Challenges
 * @property \Challenge\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \Challenge\Model\Entity\Challengeuserform get($primaryKey, $options = [])
 * @method \Challenge\Model\Entity\Challengeuserform newEmptyEntity(($data = null, array $options = [])
 * @method \Challenge\Model\Entity\Challengeuserform[] newEntities(array $data, array $options = [])
 * @method \Challenge\Model\Entity\Challengeuserform|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Challenge\Model\Entity\Challengeuserform saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Challenge\Model\Entity\Challengeuserform patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Challenge\Model\Entity\Challengeuserform[] patchEntities($entities, array $data, array $options = [])
 * @method \Challenge\Model\Entity\Challengeuserform findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ChallengeuserformsTable extends Table
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

        $this->setTable('challengeuserforms');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Challenges', [
            'foreignKey' => 'challenge_id',
            //'joinType' => 'INNER',
            'className' => 'Challenge.Challenges',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            //'joinType' => 'INNER',
            'className' => 'Challenge.Users',
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
            ->scalar('userinfo')
            ->allowEmptyString('userinfo');

        $validator
            ->scalar('filesrc')
            ->maxLength('filesrc', 200)
            ->allowEmptyFile('filesrc');

        $validator
            ->scalar('filesrc2')
            ->maxLength('filesrc2', 200)
            ->allowEmptyFile('filesrc2');

        $validator
            ->scalar('filesrc3')
            ->maxLength('filesrc3', 200)
            ->allowEmptyFile('filesrc3');

        $validator
            ->scalar('title')
            ->maxLength('title', 200)
            ->allowEmptyString('title');

        $validator
            ->scalar('descr1')
            ->allowEmptyString('descr1');

        $validator
            ->scalar('descr2')
            ->allowEmptyString('descr2');

        $validator
            ->scalar('descr3')
            ->allowEmptyString('descr3');

        $validator
            ->scalar('descr4')
            ->allowEmptyString('descr4');

        $validator
            ->scalar('descr5')
            ->allowEmptyString('descr5');

        $validator
            ->scalar('descr6')
            ->allowEmptyString('descr6');

        $validator
            ->scalar('token1')
            ->maxLength('token1', 20)
            ->allowEmptyString('token1');

        $validator
            ->boolean('enable')
            ->allowEmptyString('enable');

        $validator
            ->boolean('approved')
            ->allowEmptyString('approved');

        return $validator;
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
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['challenge_id'], 'Challenges'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
