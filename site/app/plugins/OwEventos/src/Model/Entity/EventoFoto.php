<?php
namespace OwEventos\Model\Entity;

use Cake\ORM\Entity;

class EventoFoto extends Entity
{
    protected $_accessible = [
        'evento_id' => true,
        'pasta' => true,
        'arquivo' => true,
        'legenda' => true,
        'ordem' => true,
    ];
}