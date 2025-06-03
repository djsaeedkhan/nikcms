<?php
declare(strict_types=1);

namespace Challenge\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Challengefollowers Model
 *
 * @property \Challenge\Model\Table\ChallengesTable&\Cake\ORM\Association\BelongsTo $Challenges
 * @property \Challenge\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \Challenge\Model\Entity\Challengefollower newEmptyEntity()
 * @method \Challenge\Model\Entity\Challengefollower newEntity(array $data, array $options = [])
 * @method \Challenge\Model\Entity\Challengefollower[] newEntities(array $data, array $options = [])
 * @method \Challenge\Model\Entity\Challengefollower get($primaryKey, $options = [])
 * @method \Challenge\Model\Entity\Challengefollower findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \Challenge\Model\Entity\Challengefollower patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Challenge\Model\Entity\Challengefollower[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \Challenge\Model\Entity\Challengefollower|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Challenge\Model\Entity\Challengefollower saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Challenge\Model\Entity\Challengefollower[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \Challenge\Model\Entity\Challengefollower[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \Challenge\Model\Entity\Challengefollower[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \Challenge\Model\Entity\Challengefollower[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ChallengefollowersTable extends Table
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

        $this->setTable('challengefollowers');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Challenges', [
            'foreignKey' => 'challenge_id',
            'joinType' => 'INNER',
            'className' => 'Challenge.Challenges',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
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
            ->integer('challenge_id')
            ->notEmptyString('challenge_id');

        $validator
            ->integer('user_id')
            ->notEmptyString('user_id');

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
        $rules->add($rules->existsIn('challenge_id', 'Challenges'), ['errorField' => 'challenge_id']);
        $rules->add($rules->existsIn('user_id', 'Users'), ['errorField' => 'user_id']);

        return $rules;
    }
}
