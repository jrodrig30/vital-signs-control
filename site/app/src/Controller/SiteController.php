<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

class SiteController extends AppController {

    public $components = [];

    public function index() {

        $this->loadModel($modelClass);
        $usuarios = \Cake\ORM\TableRegistry::get('OwCore.Usuarios');
        $usuario = $usuarios->newEntity([
            'nome' => 'Gerson Felipe Schwinn',
            'usuario_grupo_id' => 1,
            'email' => 'gerson@onehost.com.br',
            'senha' => 'gerson',
            'senha_confirma' => 'gerson',
            'ativo' => 1
        ]);


        $query = $usuarios->find();



        debug($query->all());
        exit;
    }

    public function sinais_vitais() {

    }

    public function pacientes() {
        $SinaisVitais = TableRegistry::get('SinaisVitais');
        $this->set('dados', $SinaisVitais->find('all')->limit(10));
        $this->set('time', 8);
    }

}
