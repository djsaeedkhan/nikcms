<?php
namespace Challenge\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Challengerelateds Model
 *
 * @property \Challenge\Model\Table\ChallengesTable&\Cake\ORM\Association\BelongsTo $Challenges
 * @property \Challenge\Model\Table\ChallengesTable&\Cake\ORM\Association\BelongsTo $Challenges
 *
 * @method \Challenge\Model\Entity\Challengerelated get($primaryKey, $options = [])
 * @method \Challenge\Model\Entity\Challengerelated newEmptyEntity($data = null, array $options = [])
 * @method \Challenge\Model\Entity\Challengerelated[] newEntities(array $data, array $options = [])
 * @method \Challenge\Model\Entity\Challengerelated|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Challenge\Model\Entity\Challengerelated saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Challenge\Model\Entity\Challengerelated patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Challenge\Model\Entity\Challengerelated[] patchEntities($entities, array $data, array $options = [])
 * @method \Challenge\Model\Entity\Challengerelated findOrCreate($search, callable $callback = null, $options = [])
 */
class ChallengerelatedsTable extends Table
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

        $this->setTable('challengerelateds');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        /* $this->belongsTo('Challenges', [
            'foreignKey' => 'challenge_id',
            'className' => 'Challenge.Challenges',
        ]);
        $this->belongsTo('Challenges', [
            'foreignKey' => 'challenges_id',
            'className' => 'Challenge.Challenges',
        ]); */

        $this->belongsTo('Challenges', [
            'className' => 'Challenges'
        ])->setForeignKey('challenge_id');

        $this->belongsTo('Challenges', [
            'className' => 'Challenges'
        ])->setForeignKey('challenges_id');
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
        $rules->add($rules->existsIn(['challenges_id'], 'Challenges'));
        $rules->add($rules->isUnique(['challenge_id','challenges_id'],''.__d('Template', 'همیاری').' قبلا استفاده شده است'));

        return $rules;
    }
}
