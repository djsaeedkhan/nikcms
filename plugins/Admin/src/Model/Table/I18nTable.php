<?php
namespace Admin\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * I18n Model
 *
 * @property \Admin\Model\Table\CategoriesTable&\Cake\ORM\Association\BelongsToMany $Categories
 * @property \Admin\Model\Table\PostsTable&\Cake\ORM\Association\BelongsToMany $Posts
 *
 * @method \Admin\Model\Entity\I18n get($primaryKey, $options = [])
 * @method \Admin\Model\Entity\I18n newEntity($data = null, array $options = [])
 * @method \Admin\Model\Entity\I18n[] newEntities(array $data, array $options = [])
 * @method \Admin\Model\Entity\I18n|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\I18n saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\I18n patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Admin\Model\Entity\I18n[] patchEntities($entities, array $data, array $options = [])
 * @method \Admin\Model\Entity\I18n findOrCreate($search, callable $callback = null, $options = [])
 */
class I18nTable extends Table
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

        $this->setTable('i18n');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsToMany('Categories', [
            'foreignKey' => 'i18n_id',
            'targetForeignKey' => 'category_id',
            'joinTable' => 'categories_i18n',
            'className' => 'Admin.Categories',
        ]);
        $this->belongsToMany('Posts', [
            'foreignKey' => 'i18n_id',
            'targetForeignKey' => 'post_id',
            'joinTable' => 'posts_i18n',
            'className' => 'Admin.Posts',
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
            ->scalar('locale')
            ->maxLength('locale', 6)
            ->requirePresence('locale', 'create')
            ->notEmptyString('locale');

        $validator
            ->scalar('model')
            ->maxLength('model', 255)
            ->requirePresence('model', 'create')
            ->notEmptyString('model');

        $validator
            ->integer('foreign_key')
            ->requirePresence('foreign_key', 'create')
            ->notEmptyString('foreign_key');

        $validator
            ->scalar('field')
            ->maxLength('field', 255)
            ->requirePresence('field', 'create')
            ->notEmptyString('field');

        $validator
            ->scalar('content')
            ->allowEmptyString('content');

        return $validator;
    }

    public function beforeSave($event){
        $entity = $event->getData('entity');
        $modified = $entity->getDirty();

        foreach((array) $entity as $enk =>$ent) {
            $entity[$enk] = strip_tags($ent);
        }

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
