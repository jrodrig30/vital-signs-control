<?php
namespace OwCore\Model\Entity;

use Cake\ORM\Entity;

/**
 * Usuario Entity.
 */
class Usuario extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'usuario_grupo_id' => true,
        'nome' => true,
        'email' => true,
        'senha' => true,
        'senha_confirma' => true,
        'obs' => true,
        'ativo' => true,
        'usuario_grupo' => true,
    ];
}
