<?php

namespace OwCore\Controller;

use App\Controller\AppController as BaseController;
use Cake\Event\Event;

class AppController extends BaseController {

    public $helpers = array('Html', 'Form', 'OwCore.OwHtml', 'OwCore.MenuHelp', 'Flash');
    public $components = array('RequestHandler', 'OwCore.OwMenuSis', 'Paginator', 'Flash', 'OwCore.Main');

    public function initialize() {        
        parent::initialize();
    }

    public function beforeFilter(Event $event) {
        if (!isset($this->Main)) {
            throw new Exception('Você deve setar o Component Main em AppController!');
        }

        if ($this->Main->isUsuarioLogado()) {
            if (method_exists($this, '_getLayout')) {
                $this->layout = $this->_getLayout();
            } else {
                $this->viewBuilder()->layout('admin');
            }
        }
        
        $this->set('ow_menu', $this->OwMenuSis->getMenu());
        
        parent::beforeFilter($event);
    }

    public function _getUsuarioId() {
        return $this->request->session()->read('Usuario.id');
    }

}
