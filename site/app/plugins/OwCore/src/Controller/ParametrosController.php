<?php
namespace OwCore\Controller;

use OwCore\Controller\AppController;

class ParametrosController extends AppController {

    public $helpers = array('OwCore.Tinymce');

    public function index() {
        $this->Parametro->recursive = 0;
        $this->set('parametros', $this->Paginator->paginate());
    }

    public function view($id = null) {
        if (!$id) {
            $this->Flash->set(__('Invalid Parametro.'));
            $this->redirect(array('action' => 'index'));
        }
        $this->set('parametro', $this->Parametro->read(null, $id));
    }

    public function add() {
        if (!empty($this->request->data)) {
            $this->Parametro->create();
            if ($this->Parametro->save($this->request->data)) {
                $this->Flash->set(__('The Parametro has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->set(__('The Parametro could not be saved. Please, try again.'));
            }
        }
    }

    public function edit($id = null) {
        if (!$id && empty($this->request->data)) {
            $this->Flash->set(__('Invalid Parametro'));
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->request->data)) {
            if ($this->Parametro->save($this->request->data)) {
                $this->Flash->set(__('The Parametro has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->set(__('The Parametro could not be saved. Please, try again.'));
            }
        }
        if (empty($this->request->data)) {
            $this->request->data = $this->Parametro->read(null, $id);
        }
    }

    public function edit_cliente($id = null) {
        if (!$id && empty($this->request->data)) {
            $this->Flash->set(__('Invalid Parametro'));
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->request->data)) {
            if ($this->Parametro->save($this->request->data)) {
                $this->Flash->set(__('The Parametro has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->set(__('The Parametro could not be saved. Please, try again.'));
            }
        }
        if (empty($this->request->data)) {
            $this->request->data = $this->Parametro->read(null, $id);
        }
    }

    public function delete($id = null) {
        if (!$id) {
            $this->Flash->set(__('Invalid id for Parametro'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->Parametro->delete($id)) {
            $this->Flash->set(__('Parametro deleted'));
            $this->redirect(array('action' => 'index'));
        }
    }

}
