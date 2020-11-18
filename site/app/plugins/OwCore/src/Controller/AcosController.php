<?php
namespace OwCore\Controller;

use OwCore\Controller\AppController;

class AcosController extends AppController {

    public $uses = array('OwCore.Aco');
    public $components = array('OwBusca.OwBusca');

    public function index() {
        $this->Aco->recursive = 0;
        $this->Paginator->settings = array(
            'Aco' => array(
                'conditions' => $this->OwBusca->getCondicoes()
            )
        );
        $this->set('owAcos', $this->Paginator->paginate());
    }

    public function view($id = null) {
        if (!$id) {
            $this->Flash->set(__('Invalid ow aco'));
            $this->redirect(array('action' => 'index'));
        }
        $this->set('owAco', $this->Aco->read(null, $id));
    }

    public function add() {
        if (!empty($this->request->data)) {
            $this->Aco->create();
            if ($this->Aco->save($this->request->data)) {
                $this->Flash->set(__('The ow aco has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->set(__('The ow aco could not be saved. Please, try again.'));
            }
        }
    }

    public function edit($id = null) {
        if (!$id && empty($this->request->data)) {
            $this->Flash->set(__('Invalid ow aco'));
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->request->data)) {
            if ($this->Aco->save($this->request->data)) {
                $this->Flash->set(__('The ow aco has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->set(__('The ow aco could not be saved. Please, try again.'));
            }
        }
        if (empty($this->request->data)) {
            $this->request->data = $this->Aco->read(null, $id);
        }
    }

    public function delete($id = null) {
        if (!$id) {
            $this->Flash->set(__('Invalid id for ow aco'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->Aco->delete($id)) {
            $this->Flash->set(__('Ow aco deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Flash->set(__('Ow aco was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

}