<?php
namespace OwEventos\Controller;

use OwCore\Controller\AppController;
use Cake\Event\Event;
use \Exception;

class OwEventosAppController extends AppController {

    public function beforeRender(Event $event) {
        $this->viewBuilder()->layout('OwCore.admin');
    }   
    
    public $helpers = array('OwCore.Tinymce', 'OwCore.MenuHelp');
}
