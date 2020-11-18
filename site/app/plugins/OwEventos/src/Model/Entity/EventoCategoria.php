<?php
namespace OwEventos\Model\Entity;

use Cake\ORM\Entity;

class EventoCategoria extends Entity
{
    protected $_accessible = [
        'evento_categoria_id' => true,
        'nome' => true,
    ];
}
