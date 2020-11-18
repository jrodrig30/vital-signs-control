<?php
namespace OwEventos\Model\Entity;

use Cake\ORM\Entity;

class Evento extends Entity
{
    protected $_accessible = [
        'evento_categoria_id' => true,
        'descricao' => true,
        'img_destaque' => true,
        'data' => true,
        'resumo' => true,
        'texto' => true,
        'destaque' => true,
    ];
}
