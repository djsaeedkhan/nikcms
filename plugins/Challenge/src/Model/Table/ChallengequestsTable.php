<?php
namespace Challenge\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Challengequests Model
 *
 * @property \Challenge\Model\Table\ChallengesTable&\Cake\ORM\Association\BelongsTo $Challenges
 * @property \Challenge\Model\Table\ChallengequestsTable&\Cake\ORM\Association\BelongsTo $ParentChallengequests
 * @property \Challenge\Model\Table\ChallengeqanswersTable&\Cake\ORM\Association\HasMany $Challengeqanswers
 * @property \Challenge\Model\Table\ChallengequestsTable&\Cake\ORM\Association\HasMany $ChildChallengequests
 *
 * @method \Challenge\Model\Entity\Challengequest get($primaryKey, $options = [])
 * @method \Challenge\Model\Entity\Challengequest newEmptyEntity($data = null, array $options = [])
 * @method \Challenge\Model\Entity\Challengequest[] newEntities(array $data, array $options = [])
 * @method \Challenge\Model\Entity\Challengequest|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Challenge\Model\Entity\Challengequest saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Challenge\Model\Entity\Challengequest patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Challenge\Model\Entity\Challengequest[] patchEntities($entities, array $data, array $options = [])
 * @method \Challenge\Model\Entity\Challengequest findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @mixin \Cake\ORM\Behavior\TreeBehavior
 */
class ChallengequestsTable extends Table
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

        $this->setTable('challengequests');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Tree');

        $this->belongsTo('Challenges', [
            'foreignKey' => 'challenge_id',
            'joinType' => 'INNER',
            'className' => 'Challenge.Challenges',
        ]);
        $this->belongsTo('ParentChallengequests', [
            'className' => 'Challenge.Challengequests',
            'foreignKey' => 'parent_id',
        ]);
        $this->hasMany('Challengeqanswers', [
            'foreignKey' => 'challengequest_id',
            'className' => 'Challenge.Challengeqanswers',
        ]);
        $this->hasMany('ChildChallengequests', [
            'className' => 'Challenge.Challengequests',
            'foreignKey' => 'parent_id',
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
            ->notEmptyString('types');

        $validator
            ->scalar('title')
            ->allowEmptyString('title');

        $validator
            ->scalar('slug')
            ->allowEmptyString('slug');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        $validator
            ->allowEmptyString('priority');

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
                    $entity->{$v} = strip_tags( (string) $entity->{$v},'<img><p><a><b><br><strong><br /><hr><i><span><div><ul><li><table><tr><td><thead><tbody>');
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
        $rules->add($rules->existsIn(['parent_id'], 'ParentChallengequests'));

        return $rules;
    }
}
