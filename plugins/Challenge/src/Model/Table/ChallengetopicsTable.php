<?php
namespace Challenge\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Challengetopics Model
 *
 * @property \Challenge\Model\Table\ChallengesTable&\Cake\ORM\Association\BelongsToMany $Challenges
 * @property &\Cake\ORM\Association\BelongsToMany $Challengeuserprofiles
 *
 * @method \Challenge\Model\Entity\Challengetopic get($primaryKey, $options = [])
 * @method \Challenge\Model\Entity\Challengetopic newEmptyEntity(($data = null, array $options = [])
 * @method \Challenge\Model\Entity\Challengetopic[] newEntities(array $data, array $options = [])
 * @method \Challenge\Model\Entity\Challengetopic|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Challenge\Model\Entity\Challengetopic saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Challenge\Model\Entity\Challengetopic patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Challenge\Model\Entity\Challengetopic[] patchEntities($entities, array $data, array $options = [])
 * @method \Challenge\Model\Entity\Challengetopic findOrCreate($search, callable $callback = null, $options = [])
 */
class ChallengetopicsTable extends Table
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

        $this->setTable('challengetopics');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->belongsToMany('Challenges', [
            'foreignKey' => 'challengetopic_id',
            'targetForeignKey' => 'challenge_id',
            'joinTable' => 'challenges_challengetopics',
            'className' => 'Challenge.Challenges',
        ]);
        $this->belongsToMany('Challengeuserprofiles', [
            'foreignKey' => 'challengetopic_id',
            'targetForeignKey' => 'challengeuserprofile_id',
            'joinTable' => 'challengeuserprofiles_challengetopics',
            'className' => 'Challenge.Challengeuserprofiles',
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
            ->scalar('title')
            ->maxLength('title', 100)
            ->requirePresence('title', 'create')
            ->notEmptyString('title');

        $validator
            ->scalar('img')
            ->maxLength('img', 200)
            ->allowEmptyString('img');

        $validator
            ->scalar('descr')
            ->allowEmptyString('descr');

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
