<?php
namespace Challenge\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Challengefields Model
 *
 * @property \Challenge\Model\Table\ChallengesTable&\Cake\ORM\Association\BelongsToMany $Challenges
 *
 * @method \Challenge\Model\Entity\Challengefield get($primaryKey, $options = [])
 * @method \Challenge\Model\Entity\Challengefield newEmptyEntity($data = null, array $options = [])
 * @method \Challenge\Model\Entity\Challengefield[] newEntities(array $data, array $options = [])
 * @method \Challenge\Model\Entity\Challengefield|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Challenge\Model\Entity\Challengefield saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Challenge\Model\Entity\Challengefield patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Challenge\Model\Entity\Challengefield[] patchEntities($entities, array $data, array $options = [])
 * @method \Challenge\Model\Entity\Challengefield findOrCreate($search, callable $callback = null, $options = [])
 */
class ChallengefieldsTable extends Table
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

        $this->setTable('challengefields');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->belongsToMany('Challenges', [
            'foreignKey' => 'challengefield_id',
            'targetForeignKey' => 'challenge_id',
            'joinTable' => 'challenges_challengefields',
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
            ->maxLength('title', 100)
            ->requirePresence('title', 'create')
            ->notEmptyString('title');

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
}
