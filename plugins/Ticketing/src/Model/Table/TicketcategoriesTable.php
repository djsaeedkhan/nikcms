<?php
namespace Ticketing\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Ticketcategories Model
 *
 * @property \Ticketing\Model\Table\TicketsTable&\Cake\ORM\Association\HasMany $Tickets
 *
 * @method \Ticketing\Model\Entity\Ticketcategory get($primaryKey, $options = [])
 * @method \Ticketing\Model\Entity\Ticketcategory newEmptyEntity(($data = null, array $options = [])
 * @method \Ticketing\Model\Entity\Ticketcategory[] newEntities(array $data, array $options = [])
 * @method \Ticketing\Model\Entity\Ticketcategory|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Ticketing\Model\Entity\Ticketcategory saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Ticketing\Model\Entity\Ticketcategory patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Ticketing\Model\Entity\Ticketcategory[] patchEntities($entities, array $data, array $options = [])
 * @method \Ticketing\Model\Entity\Ticketcategory findOrCreate($search, callable $callback = null, $options = [])
 */
class TicketcategoriesTable extends Table
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

        $this->setTable('ticketcategories');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->hasMany('Tickets', [
            'foreignKey' => 'ticketcategory_id',
            'className' => 'Ticketing.Tickets',
        ]);
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
                    $entity->{$v} = strip_tags($entity->{$v},'<button><fieldset><h1><h2><h3><h4><h5><h6><small><label><img><button><fieldset><h1><h2><h3><h4><h5><h6><small><label><img><img><p><a><b><br><strong><br /><hr><i><span><div><ul><li><table><tr><td><thead><tbody>');
                }
            }
        }
        return true;
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
            ->maxLength('title', 200)
            ->requirePresence('title', 'create')
            ->notEmptyString('title');

        return $validator;
    }
}
