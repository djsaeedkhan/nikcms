<?php
namespace Challenge\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Challengeforums Model
 *
 * @property \Challenge\Model\Table\ChallengesTable&\Cake\ORM\Association\BelongsTo $Challenges
 * @property \Challenge\Model\Table\ChallengeforumtitlesTable&\Cake\ORM\Association\BelongsTo $Challengeforumtitles
 * @property \Challenge\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \Challenge\Model\Entity\Challengeforum get($primaryKey, $options = [])
 * @method \Challenge\Model\Entity\Challengeforum newEmptyEntity($data = null, array $options = [])
 * @method \Challenge\Model\Entity\Challengeforum[] newEntities(array $data, array $options = [])
 * @method \Challenge\Model\Entity\Challengeforum|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Challenge\Model\Entity\Challengeforum saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Challenge\Model\Entity\Challengeforum patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Challenge\Model\Entity\Challengeforum[] patchEntities($entities, array $data, array $options = [])
 * @method \Challenge\Model\Entity\Challengeforum findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ChallengeforumsTable extends Table
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

        $this->setTable('challengeforums');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Challenges', [
            'foreignKey' => 'challenge_id',
            'joinType' => 'INNER',
            'className' => 'Challenge.Challenges',
        ]);
        $this->belongsTo('Challengeforumtitles', [
            'foreignKey' => 'challengeforumtitle_id',
            'joinType' => 'INNER',
            'className' => 'Challenge.Challengeforumtitles',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'className' => 'Challenge.Users',
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
            ->scalar('text')
            ->requirePresence('text', 'create')
            ->notEmptyString('text');

        $validator
            ->boolean('enable')
            ->notEmptyString('enable');

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
        $rules->add($rules->existsIn(['challengeforumtitle_id'], 'Challengeforumtitles'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
