<?php
namespace Challenge\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Challenges Model
 *
 * @property \Challenge\Model\Table\ChallengestatusesTable&\Cake\ORM\Association\BelongsTo $Challengestatuses
 * @property \Challenge\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \Challenge\Model\Table\ChallengefollowersTable&\Cake\ORM\Association\HasMany $Challengefollowers
 * @property \Challenge\Model\Table\ChallengeforumsTable&\Cake\ORM\Association\HasMany $Challengeforums
 * @property \Challenge\Model\Table\ChallengeforumtitlesTable&\Cake\ORM\Association\HasMany $Challengeforumtitles
 * @property \Challenge\Model\Table\ChallengeimagesTable&\Cake\ORM\Association\HasMany $Challengeimages
 * @property \Challenge\Model\Table\ChallengemetasTable&\Cake\ORM\Association\HasMany $Challengemetas
 * @property \Challenge\Model\Table\ChallengepartnersTable&\Cake\ORM\Association\HasMany $Challengepartners
 * @property \Challenge\Model\Table\ChallengerelatedsTable&\Cake\ORM\Association\HasMany $Challengerelateds
 * @property \Challenge\Model\Table\ChallengetextsTable&\Cake\ORM\Association\HasMany $Challengetexts
 * @property \Challenge\Model\Table\ChallengetimelinesTable&\Cake\ORM\Association\HasMany $Challengetimelines
 * @property \CHallenge\Model\Table\ChallengeuserformsTable&\Cake\ORM\Association\HasMany $Challengeuserforms
 * @property \Challenge\Model\Table\ChallengeviewsTable&\Cake\ORM\Association\HasMany $Challengeviews
 * @property \Challenge\Model\Table\ChallengecatsTable&\Cake\ORM\Association\BelongsToMany $Challengecats
 * @property \Challenge\Model\Table\ChallengefieldsTable&\Cake\ORM\Association\BelongsToMany $Challengefields
 * @property \Challenge\Model\Table\ChallengetagsTable&\Cake\ORM\Association\BelongsToMany $Challengetags
 * @property \Challenge\Model\Table\ChallengetopicsTable&\Cake\ORM\Association\BelongsToMany $Challengetopics
 *
 * @method \Challenge\Model\Entity\Challenge get($primaryKey, $options = [])
 * @method \Challenge\Model\Entity\Challenge newEmptyEntity(($data = null, array $options = [])
 * @method \Challenge\Model\Entity\Challenge[] newEntities(array $data, array $options = [])
 * @method \Challenge\Model\Entity\Challenge|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Challenge\Model\Entity\Challenge saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Challenge\Model\Entity\Challenge patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Challenge\Model\Entity\Challenge[] patchEntities($entities, array $data, array $options = [])
 * @method \Challenge\Model\Entity\Challenge findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ChallengesTable extends Table
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

        $this->setTable('challenges');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Challengestatuses', [
            'foreignKey' => 'challengestatus_id',
            //'joinType' => 'INNER',
            'className' => 'Challenge.Challengestatuses',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'className' => 'Challenge.Users',
        ]);
        $this->hasMany('Challengefollowers', [
            'foreignKey' => 'challenge_id',
            'className' => 'Challenge.Challengefollowers',
        ]);
        $this->hasMany('Challengeforums', [
            'foreignKey' => 'challenge_id',
            'className' => 'Challenge.Challengeforums',
        ]);
        $this->hasMany('Challengeforumtitles', [
            'foreignKey' => 'challenge_id',
            'className' => 'Challenge.Challengeforumtitles',
        ]);
        $this->hasMany('Challengeimages', [
            'foreignKey' => 'challenge_id',
            'className' => 'Challenge.Challengeimages',
        ]);
        $this->hasMany('Challengemetas', [
            'foreignKey' => 'challenge_id',
            'className' => 'Challenge.Challengemetas',
        ]);
        $this->hasMany('Challengepartners', [
            'foreignKey' => 'challenge_id',
            'className' => 'Challenge.Challengepartners',
        ]);
        $this->hasMany('Challengerelateds', [
            'foreignKey' => 'challenge_id',
            'className' => 'Challenge.Challengerelateds',
        ]);
        $this->hasMany('Challengetexts', [
            'foreignKey' => 'challenge_id',
            'className' => 'Challenge.Challengetexts',
        ]);
        $this->hasMany('Challengetimelines', [
            'foreignKey' => 'challenge_id',
            'className' => 'Challenge.Challengetimelines',
        ]);
        $this->hasMany('Challengeuserforms', [
            'foreignKey' => 'challenge_id',
            'className' => 'Challenge.Challengeuserforms',
        ]);
        $this->hasMany('Challengeviews', [
            'foreignKey' => 'challenge_id',
            'className' => 'Challenge.Challengeviews',
        ]);
        $this->belongsToMany('Challengecats', [
            'foreignKey' => 'challenge_id',
            'targetForeignKey' => 'challengecat_id',
            'joinTable' => 'challenges_challengecats',
            'className' => 'Challenge.Challengecats',
        ]);
        $this->belongsToMany('Challengefields', [
            'foreignKey' => 'challenge_id',
            'targetForeignKey' => 'challengefield_id',
            'joinTable' => 'challenges_challengefields',
            'className' => 'Challenge.Challengefields',
        ]);
        $this->belongsToMany('Challengetags', [
            'foreignKey' => 'challenge_id',
            'targetForeignKey' => 'challengetag_id',
            'joinTable' => 'challenges_challengetags',
            'className' => 'Challenge.Challengetags',
        ]);
        $this->belongsToMany('Challengetopics', [
            'foreignKey' => 'challenge_id',
            'targetForeignKey' => 'challengetopic_id',
            'joinTable' => 'challenges_challengetopics',
            'className' => 'Challenge.Challengetopics',
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
            ->maxLength('title', 200)
            ->requirePresence('title', 'create')
            ->notEmptyString('title');

        $validator
            ->scalar('slug')
            ->maxLength('slug', 200)
            ->requirePresence('slug', 'create')
            ->notEmptyString('slug');

        $validator
            ->integer('priority')
            ->allowEmptyString('priority');
            
        $validator
            ->scalar('descr')
            ->maxLength('descr', 500)
            ->allowEmptyString('descr');
            
        $validator
            ->scalar('password')
            ->maxLength('password', 15)
            ->allowEmptyString('password');
            
        $validator
            ->scalar('img')
            ->maxLength('img', 200)
            ->allowEmptyString('img');

        $validator
            ->scalar('img1')
            ->maxLength('img1', 200)
            ->allowEmptyString('img1');

        $validator
            ->scalar('img2')
            ->maxLength('img2', 200)
            ->allowEmptyString('img2');

        $validator
            ->scalar('start_date')
            ->maxLength('start_date', 12)
            ->allowEmptyString('start_date');

        $validator
            ->scalar('end_date')
            ->maxLength('end_date', 12)
            ->allowEmptyString('end_date');

        $validator
            ->boolean('enable')
            ->notEmptyString('enable');
        
        $validator
            ->allowEmptyString('chtype');

        $validator
            ->scalar('price')
            ->maxLength('price', 50)
            //->requirePresence('price', 'create')
            ->allowEmptyString('price');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */

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
    
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['challengestatus_id'], 'Challengestatuses'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->isUnique(['slug']));
        return $rules;
    }
}
