<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Datasource\ConnectionManager;

/**
 * Description of SinaisRequisicoesTable
 *
 * @author jose
 */
class SinaisRequisicoesTable extends Table {

    //put your code here

    public function initialize(array $config) {
        parent::initialize($config);

        $this->setTable('sinais_requisicoes');
    }

}
