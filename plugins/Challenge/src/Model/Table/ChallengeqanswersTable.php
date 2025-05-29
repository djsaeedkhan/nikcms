<?php
namespace Challenge\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Challengeqanswers Model
 *
 * @property \Challenge\Model\Table\ChallengesTable&\Cake\ORM\Association\BelongsTo $Challenges
 * @property \Challenge\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \Challenge\Model\Table\ChallengequestsTable&\Cake\ORM\Association\BelongsTo $Challengequests
 *
 * @method \Challenge\Model\Entity\Challengeqanswer get($primaryKey, $options = [])
 * @method \Challenge\Model\Entity\Challengeqanswer newEmptyEntity(($data = null, array $options = [])
 * @method \Challenge\Model\Entity\Challengeqanswer[] newEntities(array $data, array $options = [])
 * @method \Challenge\Model\Entity\Challengeqanswer|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Challenge\Model\Entity\Challengeqanswer saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Challenge\Model\Entity\Challengeqanswer patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Challenge\Model\Entity\Challengeqanswer[] patchEntities($entities, array $data, array $options = [])
 * @method \Challenge\Model\Entity\Challengeqanswer findOrCreate($search, callable $callback = null, $options = [])
 */
class ChallengeqanswersTable extends Table
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

        $this->setTable('challengeqanswers');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Challenges', [
            'foreignKey' => 'challenge_id',
            'className' => 'Challenge.Challenges',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'className' => 'Challenge.Users',
        ]);
        $this->belongsTo('Challengequests', [
            'foreignKey' => 'challengequest_id',
            'joinType' => 'INNER',
            'className' => 'Challenge.Challengequests',
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
            ->scalar('value')
            ->allowEmptyString('value');

        $validator
            ->scalar('types')
            ->maxLength('types', 10)
            ->requirePresence('types', 'create')
            ->notEmptyString('types');

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
        $rules->add($rules->existsIn(['challengequest_id'], 'Challengequests'));

        return $rules;
    }
}
