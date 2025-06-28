<?php
declare(strict_types=1);

namespace Lms\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LmsUsernotes Model
 *
 * @property \Lms\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \Lms\Model\Table\LmsCoursesTable&\Cake\ORM\Association\BelongsTo $LmsCourses
 * @property \Lms\Model\Table\LmsCoursefilesTable&\Cake\ORM\Association\BelongsTo $LmsCoursefiles
 *
 * @method \Lms\Model\Entity\LmsUsernote newEmptyEntity()
 * @method \Lms\Model\Entity\LmsUsernote newEntity(array $data, array $options = [])
 * @method \Lms\Model\Entity\LmsUsernote[] newEntities(array $data, array $options = [])
 * @method \Lms\Model\Entity\LmsUsernote get($primaryKey, $options = [])
 * @method \Lms\Model\Entity\LmsUsernote findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \Lms\Model\Entity\LmsUsernote patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Lms\Model\Entity\LmsUsernote[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \Lms\Model\Entity\LmsUsernote|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Lms\Model\Entity\LmsUsernote saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Lms\Model\Entity\LmsUsernote[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \Lms\Model\Entity\LmsUsernote[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \Lms\Model\Entity\LmsUsernote[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \Lms\Model\Entity\LmsUsernote[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class LmsUsernotesTable extends Table
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

        $this->setTable('lms_usernotes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
            'className' => 'Lms.Users',
        ]);
        $this->belongsTo('LmsCourses', [
            'foreignKey' => 'lms_course_id',
            'joinType' => 'INNER',
            'className' => 'Lms.LmsCourses',
        ]);
        $this->belongsTo('LmsCoursefiles', [
            'foreignKey' => 'lms_coursefile_id',
            'joinType' => 'INNER',
            'className' => 'Lms.LmsCoursefiles',
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
            ->integer('user_id')
            ->notEmptyString('user_id');

        $validator
            ->integer('lms_course_id')
            ->notEmptyString('lms_course_id');

        $validator
            ->integer('lms_coursefile_id')
            ->notEmptyFile('lms_coursefile_id');

        $validator
            ->scalar('text')
            ->requirePresence('text', 'create')
            ->notEmptyString('text');

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
        $rules->add($rules->existsIn('user_id', 'Users'), ['errorField' => 'user_id']);
        $rules->add($rules->existsIn('lms_course_id', 'LmsCourses'), ['errorField' => 'lms_course_id']);
        $rules->add($rules->existsIn('lms_coursefile_id', 'LmsCoursefiles'), ['errorField' => 'lms_coursefile_id']);

        return $rules;
    }
}
