<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Aco Entity.
 */
class Aco extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'tipo' => true,
        'plugin' => true,
        'controller' => true,
        'action' => true,
        'objeto' => true,
        'permissoes' => true,
    ];
}
