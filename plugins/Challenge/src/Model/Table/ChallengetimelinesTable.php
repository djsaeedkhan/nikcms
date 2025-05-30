<?php
namespace Challenge\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Challengetimelines Model
 *
 * @property \Challenge\Model\Table\ChallengesTable&\Cake\ORM\Association\BelongsTo $Challenges
 *
 * @method \Challenge\Model\Entity\Challengetimeline get($primaryKey, $options = [])
 * @method \Challenge\Model\Entity\Challengetimeline newEmptyEntity($data = null, array $options = [])
 * @method \Challenge\Model\Entity\Challengetimeline[] newEntities(array $data, array $options = [])
 * @method \Challenge\Model\Entity\Challengetimeline|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Challenge\Model\Entity\Challengetimeline saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Challenge\Model\Entity\Challengetimeline patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Challenge\Model\Entity\Challengetimeline[] patchEntities($entities, array $data, array $options = [])
 * @method \Challenge\Model\Entity\Challengetimeline findOrCreate($search, callable $callback = null, $options = [])
 */
class ChallengetimelinesTable extends Table
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

        $this->setTable('challengetimelines');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->belongsTo('Challenges', [
            'foreignKey' => 'challenge_id',
            'joinType' => 'INNER',
            'className' => 'Challenge.Challenges',
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
            ->requirePresence('title', 'create')
            ->notEmptyString('title');

        $validator
            ->notEmptyString('types');

        $validator
            ->dateTime('dates')
            ->requirePresence('dates', 'create')
            ->notEmptyDateTime('dates');

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
        $rules->add($rules->existsIn(['challenge_id'], 'Challenges'));

        return $rules;
    }

    public function beforeSave($event){
        $entity = $event->getData('entity');
        $modified = $entity->getDirty();
        foreach((array) $modified as $v) {
            if(isset($entity->{$v}) and $entity->{$v} != null) {
                if(in_array($v,['created','modified','dates'])) return true;
                if(is_array($entity->{$v})){
                    //$entity->{$v} = ($entity->{$v});
                }else{
                    $entity->{$v} = strip_tags( (string) $entity->{$v},'<img><p><a><b><br><strong><br /><hr><i><span><div><ul><li><table><tr><td><thead><tbody>');
                }
            }
        }
        return true;
    } 
}
