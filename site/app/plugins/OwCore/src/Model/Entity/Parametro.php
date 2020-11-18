<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Parametro Entity.
 */
class Parametro extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'tipo' => true,
        'descricao' => true,
        'nome' => true,
        'valor' => true,
        'obs' => true,
        'opcoes_select' => true,
    ];
}
