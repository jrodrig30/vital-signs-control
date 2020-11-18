<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use App\Lib\StartFlaskPython;
use Cake\Datasource\ConnectionManager;

/**
 * Description of MonitoramentosController
 *
 * @author jose
 */
class MonitoramentosController extends AppController {

    //put your code here
    /*
      IDS USAR
      7700
      13984
      19397
      37 |     4439
      45 |    19263
      38 |      497
      169 |     7700
      106 |    13984
      86 |    26185
      28 |    22467
      25 |    12086
      65 |     9261
      81 |     7009
      96 |    21684
      19 |     1042
      27 |    20359
      15 |    27934
      43 |    22809
      120 |    19397
      463 |     7156
      16 |    28077
      63 |    25549
      192 |    18996
      719 |    11720

     */

    public function initialize() {
        $this->loadComponent('RequestHandler');
        $this->loadModel('SinaisPacientes');
        $this->loadModel('SinaisRequisicoes');
        parent::initialize();
    }

    public function paciente($paciente = null, $horario = null) {
        $SinaisRequisicoes = TableRegistry::get('SinaisRequisicoes');

        if (!$this->request->session()->check('SERVER_PYTHON_ON')) {
            (new StartFlaskPython())->executar();
            $this->request->session()->write('SERVER_PYTHON_ON', true);
        }

        $query = $SinaisRequisicoes->find('all')
                ->where(['SinaisRequisicoes.paciente' => $paciente])
                ->order(['SinaisRequisicoes.id DESC']);
        $results = $query->all();

// Linhas são retornadas em forma de array
        $dados = $results->toArray();
        $this->set('dados', $dados);
    }

    public function pacientes() {
        $SinaisRequisicoes = TableRegistry::get('SinaisRequisicoes');
        $stmt = $this->connection->execute('SELECT *
 FROM sinais_requisicoes SinaisRequisicoes WHERE SinaisRequisicoes.id IN (
                            SELECT MAX(SinaisRequisicoes.id)
                            FROM sinais_requisicoes SinaisRequisicoes
                            GROUP BY SinaisRequisicoes.paciente
                            
                        )  
GROUP BY SinaisRequisicoes.paciente  
ORDER BY SinaisRequisicoes.id DESC');
        $dados = $stmt->fetchAll('assoc');
        $this->set('dados', $dados);
    }

    public function simulacoes() {
        if (!empty($this->request->getData())) {
            $this->set('dados', $this->request->getData());
        }
    }

    public function reiniciar_classificador() {
        $StartFlaskPython = new StartFlaskPython();
        $StartFlaskPython->reiniciar();
        return $this->redirect(['action' => 'pacientes']);
    }

    public function add() {
        $requisicao = $this->SinaisRequisicoes->newEntity($this->request->getData());
                $stmt = $this->connection->execute('SELECT *
 FROM sinais_requisicoes SinaisRequisicoes WHERE SinaisRequisicoes.paciente = ' . $requisicao->paciente . ' limit 1');
        $dados = $stmt->fetchAll('assoc');
      
        $requisicao->idade = $dados[0]['idade'];
        $requisicao->horario = date('Y-m-d H:i:s');
     
        if ($this->SinaisRequisicoes->save($requisicao)) {
            $message = 'Saved';
        } else {
            $message = 'Error';
        }


        $this->set([
            'message' => $message,
            'requisicao' => $requisicao,
            '_serialize' => ['message', 'requisicao']
        ]);
    }

}
