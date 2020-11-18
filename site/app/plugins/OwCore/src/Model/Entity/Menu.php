<?php
namespace OwCore\Model\Entity;

use Cake\ORM\Entity;

/**
 * Menu Entity.
 */
class Menu extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'menu_id' => true,
        'nome' => true,
        'plugin' => true,
        'controller' => true,
        'action' => true,
        'ordem' => true,
        'ativo' => true,
        'menus' => true,
    ];
}
