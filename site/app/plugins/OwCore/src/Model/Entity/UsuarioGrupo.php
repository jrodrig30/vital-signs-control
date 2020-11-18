<?php
namespace OwCore\Model\Entity;

use Cake\ORM\Entity;

/**
 * UsuarioGrupo Entity.
 */
class UsuarioGrupo extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'nome' => true,
        'identificacao' => true,
        'root' => true,
        'permissoes' => true,
        'usuarios' => true,
    ];
}
