<?php
declare(strict_types=1);

namespace Challenge\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Challengerelateds Model
 *
 * @property \App\Model\Table\ChallengesTable&\Cake\ORM\Association\BelongsTo $Challenges
 * @property \App\Model\Table\ChallengesTable&\Cake\ORM\Association\BelongsTo $Challenges
 *
 * @method \Challenge\Model\Entity\Challengerelated newEmptyEntity()
 * @method \Challenge\Model\Entity\Challengerelated newEntity(array $data, array $options = [])
 * @method \Challenge\Model\Entity\Challengerelated[] newEntities(array $data, array $options = [])
 * @method \Challenge\Model\Entity\Challengerelated get($primaryKey, $options = [])
 * @method \Challenge\Model\Entity\Challengerelated findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \Challenge\Model\Entity\Challengerelated patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Challenge\Model\Entity\Challengerelated[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \Challenge\Model\Entity\Challengerelated|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Challenge\Model\Entity\Challengerelated saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Challenge\Model\Entity\Challengerelated[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \Challenge\Model\Entity\Challengerelated[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \Challenge\Model\Entity\Challengerelated[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \Challenge\Model\Entity\Challengerelated[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
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

        $this->belongsTo('Challenges', [
            'foreignKey' => 'challenge_id',
            'joinType' => 'INNER',
            'className' => 'Challenge.Challenges',
        ]);
        $this->belongsTo('Challenges', [
            'foreignKey' => 'challenges_id',
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
            ->integer('challenge_id')
            ->notEmptyString('challenge_id');

        $validator
            ->integer('challenges_id')
            ->notEmptyString('challenges_id');

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
        $rules->add($rules->existsIn(['challenge_id'], 'Challenges'), ['errorField' => 'challenge_id']);
        $rules->add($rules->existsIn(['challenges_id'], 'Challenges'), ['errorField' => 'challenge_id']);
        $rules->add($rules->isUnique(['challenge_id','challenges_id'],''.__d('Template', 'همیاری').' قبلا استفاده شده است'));
        return $rules;
    }
}
