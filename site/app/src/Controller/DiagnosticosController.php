<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Core\Exception\Exception;
use App\Lib\ClassificaAtributos;

/**
 * Description of DiagnosticosController
 *
 * @author jose
 */
class DiagnosticosController extends AppController {

    public function initialize() {
        $this->loadModel('Sinais');
        parent::initialize();
    }

    public function index() {
        $diagnosticos = $this->paginate($this->Diagnosticos);
        $this->set(compact('diagnosticos'));
        $this->set('_serialize', ['diagnosticos']);
    }

    public function add() {
        $diagnostico = $this->Diagnosticos->newEntity();
        if ($this->request->is('post')) {
            try {
                $this->connection->begin();
                $diagnostico = $this->Diagnosticos->patchEntity($diagnostico, $this->request->getData(), [
                    'associated' => ['DiagnosticosSinais']
                ]);

                $Parametros = TableRegistry::get('Parametros');
                $query = $Parametros->find('all')->where(['Parametros.nome' => 'ULTIMA_LINHA']);
                $parametro = $query->toArray();
                $diagnostico->linha = $parametro[0]->valor;

                if ($this->Diagnosticos->save($diagnostico) === false) {
                    throw new Exception('Não foi possível salvar o diagnóstico!');
                }

                $ClassificaAtributos = new ClassificaAtributos();
                $ClassificaAtributos->atualizarScript($this->request->getData());
                $this->connection->commit();
                $this->Flash->success('Diagnóstico salvo com sucesso!');
                return $this->redirect(['action' => 'index']);
            } catch (Exception $ex) {
                $this->connection->rollback();
                $this->Flash->error($ex->getMessage());
            }
        }

        $query = $this->Sinais->find('list');
        $sinais = $query->toArray();
        $this->set(compact('diagnostico', 'sinais'));
        $this->set('_serialize', ['diagnostico']);
    }

    public function edit($id = null) {
            $diagnostico = $this->Diagnosticos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            try {
                $this->connection->begin();
                $diagnostico = $this->Diagnosticos->patchEntity($diagnostico, $this->request->getData());
                $this->Diagnosticos->save($diagnostico);
                $this->Flash->success('O diagnóstico foi editado com sucesso!');
                $ClassificaAtributos = new ClassificaAtributos();
                $ClassificaAtributos->atualizarScript($this->request->getData());
                $this->connection->commit();

                return $this->redirect(['action' => 'index']);
            } catch (Exception $ex) {
                $this->connection->rollback();
                $this->Flash->error('O diagnóstico não pode ser editado. Por favor, tente novamente.');
                $ClassificaAtributos->atualizarScript($this->request->getData());
                return $this->redirect(['action' => 'index']);
            }
        }
       
        
        $query = $this->Sinais->find('list');
        $sinais = $query->toArray();
        $this->set(compact('diagnostico', 'sinais'));
        $this->set('_serialize', ['diagnostico']);
    }

    public function view() {
        
    }

    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $diagnostico = $this->Diagnosticos->get($id);
        $ClassificaAtributos = new ClassificaAtributos();
        if ($ClassificaAtributos->removerLinhaScript(($diagnostico->linha + 1)) == false) {
            throw new Exception('O diagnóstico não pode ser removido. Problema na remoção de linha do script!');
        }


        if ($this->Diagnosticos->delete($diagnostico)) {
            $this->Flash->success('O diagnóstico foi removido.');
        } else {
            $this->Flash->error('O diagnóstico não pode ser removido.');
        }

        return $this->redirect(['action' => 'index']);
    }

    public function gerar_classificador() {
        $ClassificaAtributos = new ClassificaAtributos();
        $ClassificaAtributos->start();
        $this->Flash->success('Foi gerado um novo classificador!');
        return $this->redirect(['action' => 'index']);
    }

}
