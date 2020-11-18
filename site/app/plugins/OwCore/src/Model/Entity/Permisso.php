<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Permisso Entity.
 */
class Permisso extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'usuario_grupo_id' => true,
        'aco_id' => true,
        'usuario_grupo' => true,
        'aco' => true,
    ];
}
