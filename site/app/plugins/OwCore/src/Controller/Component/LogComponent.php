<?php
namespace OwCore\Controller\Component;

use Cake\Controller\Component;
use OwCore\Lib\OwLog;

App::uses('Usuario', 'OwCore.Model');
App::uses('CakeSession', 'Model/Datasource');

class LogComponent extends Component {

    public $components = array('RequestHandler');
    public $log_dados = array();
    private $usuario_id;

    public function initialize(Controller $controller) {
        
        //opcao para não logar GET, nem sempre é necessário
        if(isset($this->settings['logGET']) && $this->settings['logGET'] == false){
            if($controller->request->is('get')){
                return;
            }
        }
        
        $isRequest = isset($controller->request->params['requested']) && $controller->request->params['requested'] == 1;
        if($isRequest){
            if(!isset($this->settings['logRequestAction']) || $this->settings['logRequestAction'] == false){
                return;
            }
        }
        
        $this->_setUsuarioId($controller->request->data);
        $this->_setDadosLog($controller);
        $this->_createLogArquivo($this->log_dados);
        parent::initialize($controller);
    }

    private function _setDadosLog() {
        $log_dados = [];
        
        $event = new CakeEvent('OwCore.Component.Log.beforeSetDadosLog', $this, ['dados' => $log_dados]);
        CakeEventManager::instance()->dispatch($event);
        if(isset($event->result['dados'])){
            $log_dados = $event->result['dados'];
        }
        
        $log_dados['data_horario'] = date('Y-m-d H:i:s');
        $log_dados['ip'] = $this->_getUserIp();
        $log_dados['metodo'] = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : '';
        $log_dados['usuario_id'] = $this->usuario_id;
        $log_dados['usuario_nome'] = $this->_getNomeUsuario();
        $log_dados['url'] = $this->_getUrl();
        $log_dados['dados'] = $this->_getRequest();
        $this->log_dados = $log_dados;
        $event = new CakeEvent('OwCore.Component.Log.afterSetDadosLog', $this, ['dados' => $log_dados]);
        CakeEventManager::instance()->dispatch($event);
        if(isset($event->result['dados'])){
            $this->log_dados = $event->result['dados'];
        }
        
        $this->log_dados['dados'] = serialize($this->log_dados['dados']);
    }
    
    public function setLogDados($dados){
        $this->log_dados = $dados;
    }
    
    public function getLogDados(){
        return $this->log_dados;
    }

    private function _getUserIp() {
        return !empty($this->RequestHandler->getClientIP()) ? $this->RequestHandler->getClientIP() : "";
    }

    private function _setUsuarioId($dados_usuario) {
        $usuario = CakeSession::read('Usuario');
        if (empty($usuario)) {
            $this->usuario_id = $this->_getUsuarioIdByEmail($dados_usuario);
        }

        $this->usuario_id = $usuario['id'];
    }

    private function _getUsuarioIdByEmail($dados_usuario) {
        if (!empty($dados_usuario['Usuario']['email'])) {
            $usuario_email = $this->_getObjUsuario()->findByEmail($dados_usuario['Usuario']['email']);
            return $usuario_email['Usuario']['id'];
        }

        return "";
    }

    private function _getNomeUsuario() {
        $usuario = CakeSession::read('Usuario');
        if (empty($usuario)) {
            return $this->_getUsuarioNomeById();
        }

        return $usuario['nome'];
    }

    private function _getUsuarioNomeById() {
        if (!empty($this->usuario_id)) {
            $usuario = $this->_getObjUsuario()->findById($this->usuario_id);
            return $usuario['Usuario']['nome'];
        }

        return "";
    }

    private function _getUrl() {
        return !empty($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : "";
    }

    private function _getRequest() {
        $dados['Session'] = !empty($_SESSION) ? $_SESSION : null;
        $dados['Post'] = !empty($_POST) ? $_POST : null;
        return $dados;
    }

    private function _createLogArquivo() {
        $pasta = isset($this->settings['pasta']) ? $this->settings['pasta'] : null;
        OwLog::salvarDadosLogEmArquivo($this->log_dados, $pasta);
    }

    private function _getObjUsuario() {
        return ClassRegistry::init('OwCore.Usuario');
    }

}
