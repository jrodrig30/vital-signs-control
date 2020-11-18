<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DItem Entity
 *
 * @property int $row_id
 * @property int $itemid
 * @property string $label
 * @property string $abbreviation
 * @property string $dbsource
 * @property string $linksto
 * @property string $category
 * @property string $unitname
 * @property string $param_type
 * @property int $conceptid
 *
 * @property \App\Model\Entity\Row $row
 */
class Diagnostico extends Entity {

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
        '*' => true
    ];

}
