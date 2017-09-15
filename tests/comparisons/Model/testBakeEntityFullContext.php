<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * BakeArticle Entity
 *
 * @property int $id
 * @property int $bake_user_id
 * @property string $title
 * @property string $body
 * @property bool $published
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $updated
 *
 * @property \App\Model\Entity\BakeUser $bake_user
 * @property \App\Model\Entity\BakeComment[] $bake_comments
 * @property \App\Model\Entity\BakeTag[] $bake_tags
 */
class BakeArticle extends Entity
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
        'bake_user_id' => true,
        'title' => true,
        'body' => true,
        'published' => true,
        'created' => true,
        'updated' => true,
        'bake_user' => true,
        'bake_comments' => true,
        'bake_tags' => true
    ];
}