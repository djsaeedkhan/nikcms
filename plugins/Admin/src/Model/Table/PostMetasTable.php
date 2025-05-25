<?php
namespace Admin\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PostMetas Model
 *
 * @property \Admin\Model\Table\PostsTable&\Cake\ORM\Association\BelongsTo $Posts
 *
 * @method \Admin\Model\Entity\PostMeta get($primaryKey, $options = [])
 * @method \Admin\Model\Entity\PostMeta newEntity($data = null, array $options = [])
 * @method \Admin\Model\Entity\PostMeta[] newEntities(array $data, array $options = [])
 * @method \Admin\Model\Entity\PostMeta|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\PostMeta saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\PostMeta patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Admin\Model\Entity\PostMeta[] patchEntities($entities, array $data, array $options = [])
 * @method \Admin\Model\Entity\PostMeta findOrCreate($search, callable $callback = null, $options = [])
 */
class PostMetasTable extends Table
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
        $this->setTable('post_metas');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        //$this->addBehavior('Translate', ['fields' => ['meta_value']]);
        /* $this->belongsTo('Posts', [
            'foreignKey' => 'post_id',
            'joinType' => 'INNER',
            'className' => 'Admin.Posts',
        ]); */
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
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('meta_type')
            ->maxLength('meta_type', 255)
            ->requirePresence('meta_type', 'create')
            ->notEmptyString('meta_type');

        $validator
            ->scalar('meta_key')
            ->maxLength('meta_key', 255)
            ->allowEmptyString('meta_key');

        $validator
            ->scalar('meta_value')
            ->maxLength('meta_value', 4294967295)
            ->allowEmptyString('meta_value');

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
        //$rules->add($rules->existsIn(['post_id'], 'Posts'));

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
                    $entity->{$v} = strip_tags($entity->{$v},'<source><iframe><video><mp3><img><p><a><b><br><strong><br /><hr><i><span><div><ul><li><table><tr><td><thead><tbody>');
                }
            }
        }
        return true;
    }
}
