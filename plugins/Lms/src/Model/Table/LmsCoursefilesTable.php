<?php
namespace Lms\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LmsCoursefiles Model
 *
 * @property \Lms\Model\Table\LmsCoursesTable&\Cake\ORM\Association\BelongsTo $LmsCourses
 * @property \Lms\Model\Table\LmsCourseweeksTable&\Cake\ORM\Association\BelongsTo $LmsCourseweeks
 * @property \Lms\Model\Table\LmsCourseexamsTable&\Cake\ORM\Association\HasMany $LmsCourseexams
 * @property \Lms\Model\Table\LmsCoursefilecansTable&\Cake\ORM\Association\HasMany $LmsCoursefilecans
 * @property \Lms\Model\Table\LmsCoursefilenotesTable&\Cake\ORM\Association\HasMany $LmsCoursefilenotes
 * @property \Lms\Model\Table\LmsCoursesessionsTable&\Cake\ORM\Association\HasMany $LmsCoursesessions
 * @property \Lms\Model\Table\LmsExamresultsTable&\Cake\ORM\Association\HasMany $LmsExamresults
 * @property \Lms\Model\Table\LmsUsernotesTable&\Cake\ORM\Association\HasMany $LmsUsernotes
 *
 * @method \Lms\Model\Entity\LmsCoursefile get($primaryKey, $options = [])
 * @method \Lms\Model\Entity\LmsCoursefile newEntity($data = null, array $options = [])
 * @method \Lms\Model\Entity\LmsCoursefile[] newEntities(array $data, array $options = [])
 * @method \Lms\Model\Entity\LmsCoursefile|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Lms\Model\Entity\LmsCoursefile saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Lms\Model\Entity\LmsCoursefile patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Lms\Model\Entity\LmsCoursefile[] patchEntities($entities, array $data, array $options = [])
 * @method \Lms\Model\Entity\LmsCoursefile findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class LmsCoursefilesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('lms_coursefiles');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('LmsCourses', [
            'foreignKey' => 'lms_course_id',
            //'joinType' => 'INNER',
            'className' => 'Lms.LmsCourses',
        ]);
        $this->belongsTo('LmsCourseweeks', [
            'foreignKey' => 'lms_courseweek_id',
            //'joinType' => 'INNER',
            'className' => 'Lms.LmsCourseweeks',
        ]);
        $this->hasMany('LmsCourseexams', [
            'foreignKey' => 'lms_coursefile_id',
            'className' => 'Lms.LmsCourseexams',
        ]);
        $this->hasMany('LmsCoursefilecans', [
            'foreignKey' => 'lms_coursefile_id',
            'className' => 'Lms.LmsCoursefilecans',
        ]);
        $this->hasMany('LmsCoursefilenotes', [
            'foreignKey' => 'lms_coursefile_id',
            'className' => 'Lms.LmsCoursefilenotes',
        ]);
        $this->hasMany('LmsCoursesessions', [
            'foreignKey' => 'lms_coursefile_id',
            'className' => 'Lms.LmsCoursesessions',
        ]);
        $this->hasMany('LmsExamresults', [
            'foreignKey' => 'lms_coursefile_id',
            'className' => 'Lms.LmsExamresults',
        ]);
        $this->hasMany('LmsUsernotes', [
            'foreignKey' => 'lms_coursefile_id',
            'className' => 'Lms.LmsUsernotes',
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
            ->maxLength('title', 300)
            ->allowEmptyString('title');

        $validator
            ->notEmptyString('days');

        $validator
            ->scalar('filesrc_1')
            ->allowEmptyFile('filesrc_1');

        $validator
            ->scalar('filesrc_2')
            ->allowEmptyFile('filesrc_2');

        $validator
            ->scalar('filesrc_3')
            ->allowEmptyFile('filesrc_3');

        $validator
            ->scalar('filesrc_4')
            ->allowEmptyFile('filesrc_4');

        $validator
            ->scalar('filesrc_extra')
            ->allowEmptyFile('filesrc_extra');

        $validator
            ->scalar('preview')
            ->maxLength('preview', 1000)
            ->allowEmptyString('preview');

        $validator
            ->scalar('content')
            ->allowEmptyString('content');

        $validator
            ->scalar('top_content')
            ->maxLength('top_content', 5000)
            ->allowEmptyString('top_content');

        $validator
            ->scalar('total_time')
            ->maxLength('total_time', 50)
            ->allowEmptyString('total_time');

        $validator
            ->allowEmptyString('priority');

        $validator
            ->scalar('image')
            ->maxLength('image', 200)
            ->allowEmptyFile('image');

        $validator
            ->boolean('enable')
            ->notEmptyString('enable');

        $validator
            ->allowEmptyString('show_in_list');
            
        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['lms_course_id'], 'LmsCourses'));
        $rules->add($rules->existsIn(['lms_courseweek_id'], 'LmsCourseweeks'));

        return $rules;
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
