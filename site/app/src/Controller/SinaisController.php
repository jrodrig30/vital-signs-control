<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * Description of SinaisController
 *
 * @author jose
 */
class SinaisController extends AppController {

    public function index() {
        $sinais = $this->paginate($this->Sinais);

        $this->set(compact('sinais'));
        $this->set('_serialize', ['sinais']);
    }

    public function add() {
        $sinal = $this->Sinais->newEntity();
        if ($this->request->is('post')) {
            try {
                $this->connection->begin();
                $sinal = $this->Sinais->patchEntity($sinal, $this->request->getData());
                if ($this->Sinais->save($sinal) === false) {
                    throw new Exception('Não foi possível salvar o sinal!');
                }

                $this->connection->commit();
                $this->Flash->success('Sinal salvo com sucesso!');
                return $this->redirect(['action' => 'index']);
            } catch (Exception $ex) {
                $this->connection->rollback();
                $this->Flash->error($ex->getMessage());
            }
        }

        $this->set(compact('sinal'));
        $this->set('_serialize', ['sinal']);
    }

    public function edit($id=null) {
        $sinal = $this->Sinais->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $sinal = $this->Sinais->patchEntity($sinal, $this->request->getData());
            if ($this->Sinais->save($sinal)) {
                $this->Flash->success('O sinal foi editado com sucesso!');

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('O sinal não pode ser editado. Por favor, tente novamente.');
        }
        $this->set(compact('sinal'));
        $this->set('_serialize', ['sinal']);
    }

    public function view() {
        
    }

    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $sinal = $this->Sinais->get($id);
        if ($this->Sinais->delete($sinal)) {
            $this->Flash->success('Sinal removido.');
        } else {
            $this->Flash->error('O Sinal não pode ser removido.');
        }

        return $this->redirect(['action' => 'index']);
    }

}
