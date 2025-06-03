<?php
declare(strict_types=1);

namespace Challenge\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Challengestatuses Model
 *
 * @property \Challenge\Model\Table\ChallengesTable&\Cake\ORM\Association\HasMany $Challenges
 *
 * @method \Challenge\Model\Entity\Challengestatus newEmptyEntity()
 * @method \Challenge\Model\Entity\Challengestatus newEntity(array $data, array $options = [])
 * @method \Challenge\Model\Entity\Challengestatus[] newEntities(array $data, array $options = [])
 * @method \Challenge\Model\Entity\Challengestatus get($primaryKey, $options = [])
 * @method \Challenge\Model\Entity\Challengestatus findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \Challenge\Model\Entity\Challengestatus patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Challenge\Model\Entity\Challengestatus[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \Challenge\Model\Entity\Challengestatus|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Challenge\Model\Entity\Challengestatus saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Challenge\Model\Entity\Challengestatus[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \Challenge\Model\Entity\Challengestatus[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \Challenge\Model\Entity\Challengestatus[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \Challenge\Model\Entity\Challengestatus[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class ChallengestatusesTable extends Table
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

        $this->setTable('challengestatuses');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->hasMany('Challenges', [
            'foreignKey' => 'challengestatus_id',
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
            ->scalar('title')
            ->maxLength('title', 100)
            ->requirePresence('title', 'create')
            ->notEmptyString('title');

        return $validator;
    }
}
