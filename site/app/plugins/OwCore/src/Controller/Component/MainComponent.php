<?php

namespace OwCore\Controller\Component;

use Cake\Controller\Component;
use OwCore\Lib\PermissaoLib;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use \Exception;
use Cake\Routing\Router;

class MainComponent extends Component {

    private $controller;
    public $components = ['Flash'];
    public $loginAction = array('plugin' => 'OwCore', 'controller' => 'Usuarios', 'action' => 'login');
    public $logoutRedirect = array('plugin' => 'OwCore', 'controller' => 'Usuarios', 'action' => 'login');
    public $loginRedirect = array('plugin' => 'OwCore', 'controller' => 'Usuarios', 'action' => 'meus_dados');
    public $autoRedirect = true;

    public function initialize(array $config = []) {
        $this->controller = $this->_registry->getController();
        $this->_setConfig($config);
    }

    private function _setConfig($controllerConfig = []) {
        if (isset($controllerConfig['loginRedirect'])) {
            $this->loginRedirect = $controllerConfig['loginRedirect'];
        }

        if (isset($controllerConfig['logoutRedirect'])) {
            $this->logoutRedirect = $controllerConfig['logoutRedirect'];
        }

        if (isset($controllerConfig['loginAction'])) {
            $this->loginAction = $controllerConfig['loginAction'];
        }
    }

    public function startup(Event $event) {
        $this->autorizarUrl($this->loginAction);
        $this->verificarSeEstaLogadoEAcessandoPaginaLogin();
        $this->verificarPermissoes();
    }

    private function verificarSeEstaLogadoEAcessandoPaginaLogin() {
        if (!$this->isUsuarioLogado()) {
            return;
        }
        
        $atual = $this->getUrlAtual();
        $login = $this->montaUrl($this->loginAction['plugin'], $this->loginAction['controller'], $this->loginAction['action']);
        
        if ($atual === $login) {
            $this->controller->redirect($this->loginRedirect);
        }
    }

    public function fazerLogin($user) {
        //5debug('entrou');exit;
        if (!is_array($user)) {
            $usuario = TableRegistry::get('Usuarios');
            $user = $usuario->get($user);
        }
        
        $this->request->session()->write('Usuario', $user);

        if (!$this->request->session()->read('Usuario')) {
            throw new Exception('Não foi possível fazer o login!');
        }

        PermissaoLib::makeLogin($user);

        if ($this->autoRedirect) {
            $url = $this->loginRedirect;

            if ($this->request->session()->check('OwCore.UrlNegada')) {
                $urlNegada = Router::normalize($this->request->session()->read('OwCore.UrlNegada'));
                if ($urlNegada !== Router::normalize($this->loginAction)) {
                    $url = $urlNegada;
                }
                $this->request->session()->delete('OwCore.UrlNegada');
            }

            $this->controller->redirect($url);
        }
    }

    public function fazerLogout() {
        //8debug('entrou');exit;
        PermissaoLib::makeLogout();
        $this->request->session()->delete('Usuario');
        if ($this->autoRedirect) {
            $this->controller->redirect($this->logoutRedirect);
        }
    }

    public function checarUsuarioLogado() {
        //debug('entrou');exit;
        if (!$this->isUsuarioLogado()) {
            $this->request->session()->write('OwCore.UrlNegada', $this->getUrlAtual());
            $this->controller->Flash->set('Faça o login!');
            $this->controller->redirect($this->loginAction);
        }
    }

    public function isUsuarioLogado() {
        return $this->request->session()->check('Usuario');
    }

    public function getUsuarioLogado() {
        //6debug('entrou');exit;
        $dados['Usuario'] = $this->request->session()->read('Usuario');
        return $dados;
    }

    public function getUsuarioValido($email, $senha) {
        //4debug('entrou');exit;        
        $usuarios = TableRegistry::get('OwCore.Usuarios');
        $usuario = $usuarios->findByEmail($email)->first();
        if (empty($usuario)) {
            throw new Exception('Usuário não encontrado!');
        }

        $senhaAtual = $usuarios->getSenhaCriptografada($senha, $usuario->senha);

        if ($senhaAtual !== $usuario->senha) {
            throw new Exception('Usuário ou senha inválidos!');
        }

        return $usuario;
    }

    public function montaUrl($plugin, $controller, $action) {
        //2debug('entrou');exit;
        $url = '';
        if (strlen($plugin)) {
            $url .= '/' . $plugin;
        }
        $url .= '/' . $controller;
        $url .= '/' . $action;
        return $url;
    }

    public function getUrlAtual($formatoArray = false) {
        $plugin = $this->controller->request->params['plugin'];
        $controller = $this->controller->request->params['controller'];
        $action = $this->controller->request->params['action'];

        if ($formatoArray) {
            return [
                'plugin' => $plugin,
                'controller' => $controller,
                'action' => $action
            ];
        }
        return $this->montaUrl($plugin, $controller, $action);
    }

    public function verificarPermissoes() {
        $url = $this->getUrlAtual(true);
        if (PermissaoLib::isUrlAutorizada($url)) {
            return;
        }

        $this->checarUsuarioLogado();
        $usuario_grupo_id = PermissaoLib::getIdGrupoUsuarioSessao();
        if (!PermissaoLib::temPermissaoUrl($usuario_grupo_id, $url)) {
            $this->controller->Flash->set('Você não tem permissão para acessar este endereço!');
            $this->controller->redirect($this->loginRedirect);
        }
    }

    public function autorizarAction($action) {
        debug('entrou');exit;
        $plugin = $this->controller->params['plugin'];
        $controller = $this->controller->params['controller'];
        $action = $action;
        $url = $this->montaUrl($plugin, $controller, $action);
        $this->autorizarUrl($url);
    }

    public function autorizarUrl($url) {
        if ($url == '*') {
            $url = $this->getUrlAtual(true);
        }

        PermissaoLib::autorizarUrl($url);
    }

    public function allow($url) {
        //7debug('entrou');
        //exit;
        $this->autorizarUrl($url);
    }

    public function beforeRender(Event $event) {
        //3debug('entrou');exit;
        if ($this->isUsuarioLogado()) {
            $this->controller->set('usuario_logado', $this->getUsuarioLogado());
        }
    }

}
