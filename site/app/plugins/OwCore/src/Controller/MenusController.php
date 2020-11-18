<?php
namespace OwCore\Controller;

use OwCore\Controller\AppController;
use Cake\Event\Event;

class MenusController extends AppController {

    public $uses = array('OwCore.Menu');
    public $layout = 'OwCore.admin';

    public function beforeFilter(Event $event) {
        $this->Main->allow(array('plugin' => 'ow_core', 'controller' => 'menus', 'action' => 'request_menus'));
        parent::beforeFilter($event);
    }
    
    public function index() {
        $this->Menu->recursive = 0;
        $this->set('owMenus', $this->Paginator->paginate());
    }
    
    public function request_menus(){
        return $this->OwMenuSis->getMenu();
    }

    public function view($id = null) {
        if (!$id) {
            $this->Flash->set(__('Invalid ow menu'));
            $this->redirect(array('action' => 'index'));
        }
        $this->set('owMenu', $this->Menu->read(null, $id));
    }

    public function add() {
        if (!empty($this->request->data)) {
            $this->Menu->create();
            if ($this->Menu->save($this->request->data)) {
                $this->Flash->set(__('The ow menu has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->set(__('The ow menu could not be saved. Please, try again.'));
            }
        }

        $this->set('ow_menus',$this->Menu->listarNomeCompleto());
    }

    public function edit($id = null) {
        if (!$id && empty($this->request->data)) {
            $this->Flash->set(__('Invalid ow menu'));
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->request->data)) {
            if ($this->Menu->save($this->request->data)) {
                $this->Flash->set(__('The ow menu has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->set(__('The ow menu could not be saved. Please, try again.'));
            }
        }
        if (empty($this->request->data)) {
            $this->request->data = $this->Menu->read(null, $id);
        }
        $this->set('ow_menus',$this->Menu->listaMenusPrincipais());
    }
    
    public function ativar($id) {
        $this->Menu->id = $id;
        $this->Menu->saveField('ativo', 1);
        $this->Flash->set(__('Menu ativado com sucesso!'));
        $this->redirect(array('action' => 'index'));
    }
    
    public function desativar($id) {
        $this->Menu->id = $id;
        $this->Menu->saveField('ativo', 0);
        $this->Flash->set(__('Menu desativado com sucesso!'));
        $this->redirect(array('action' => 'index'));
    }

    public function delete($id = null) {
        if (!$id) {
            $this->Flash->set(__('Invalid id for ow menu'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->Menu->delete($id)) {
            $this->Flash->set(__('Ow menu deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Flash->set(__('Ow menu was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

}