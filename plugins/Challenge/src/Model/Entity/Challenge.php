<?php
namespace Challenge\Model\Entity;

use Cake\ORM\Entity;

/**
 * Challenge Entity
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string|null $descr
 * @property string|null $img
 * @property string|null $img1
 * @property string|null $img2
 * @property int $challengestatus_id
 * @property string|null $start_date
 * @property string|null $end_date
 * @property int|null $user_id
 * @property bool $enable
 * @property string $price
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \Challenge\Model\Entity\Challengestatus $challengestatus
 * @property \Challenge\Model\Entity\User $user
 * @property \Challenge\Model\Entity\Challengefollower[] $challengefollowers
 * @property \Challenge\Model\Entity\Challengeforum[] $challengeforums
 * @property \Challenge\Model\Entity\Challengeforumtitle[] $challengeforumtitles
 * @property \Challenge\Model\Entity\Challengeimage[] $challengeimages
 * @property \Challenge\Model\Entity\Challengemeta[] $challengemetas
 * @property \Challenge\Model\Entity\Challengepartner[] $challengepartners
 * @property \Challenge\Model\Entity\Challengerelated[] $challengerelateds
 * @property \Challenge\Model\Entity\Challengetext[] $challengetexts
 * @property \Challenge\Model\Entity\Challengetimeline[] $challengetimelines
 * @property \Challenge\Model\Entity\Challengeuserform[] $challengeuserforms
 * @property \Challenge\Model\Entity\Challengeview[] $challengeviews
 * @property \Challenge\Model\Entity\Challengecat[] $challengecats
 * @property \Challenge\Model\Entity\Challengefield[] $challengefields
 * @property \Challenge\Model\Entity\Challengetag[] $challengetags
 * @property \Challenge\Model\Entity\Challengetopic[] $challengetopics
 */
class Challenge extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'title' => true,
        'slug' => true,
        'priority' => true,
        'descr' => true,
        'password' => true,
        'img' => true,
        'img1' => true,
        'img2' => true,
        'challengestatus_id' => true,
        'start_date' => true,
        'end_date' => true,
        'user_id' => true,
        'enable' => true,
        'price' => true,
        'chtype' => true,
        'created' => true,
        'challengestatus' => true,
        'user' => true,
        'challengefollowers' => true,
        'challengeforums' => true,
        'challengeforumtitles' => true,
        'challengeimages' => true,
        'challengemetas' => true,
        'challengepartners' => true,
        'challengerelateds' => true,
        'challengetexts' => true,
        'challengetimelines' => true,
        'challengeuserforms' => true,
        'challengeviews' => true,
        'challengecats' => true,
        'challengefields' => true,
        'challengetags' => true,
        'challengetopics' => true,
    ];
}
