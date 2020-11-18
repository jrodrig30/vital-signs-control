<?php
namespace OwCore\Lib;

use Cake\Core\App;
use Cake\ORM\TableRegistry;
use Cake\Core\Plugin;
use ReflectionClass;
use ReflectionMethod;
use Cake\Utility\Inflector;

class CarregaActionsLib {

    private $urlsNovas = [];
    private $urlsRemovidas = [];

    public function atualizarCadastroUrls() {
        $this->Aco = TableRegistry::get('OwCore.Acos');
        $urls_sistema = $this->getUrlsSistema();
        foreach ($urls_sistema as $url) {
            if ($this->Aco->existeUrl($url)) {              
                continue;
            }

            if ($this->Aco->salvarUrl($url)) {
                var_dump('Salvando URL ' . $url['plugin'] . '/' . $url['controller'] . '/' . $url['action']);
                $this->urlsNovas[] = $url;
            }
        }
        $urls_existentes = $this->Aco->getUrls();
        foreach ($urls_existentes as $url) {
            if (!$this->existeUrl($url, $urls_sistema)) {
                var_dump('Removendo URL ' . $url['plugin'] . '/' . $url['controller'] . '/' . $url['action']);
                $this->Aco->removerUrl($url);
                $this->urlsRemovidas[] = $url;
            }
        }
    }

    public function getUrlsSistema() {
        $controllers = $this->listarControllers();
        $baseMethods = $this->_getClassMethods('App', true);
        $urls = array();
        foreach ($controllers as $ctrlName) {
            $methods = $this->_getClassMethods($ctrlName);
            $nome_plugin = null;
            $nome_controller = $ctrlName;
            if ($this->_isPlugin($ctrlName)) {
                $nome_plugin = $this->_getPluginName($ctrlName);
                $nome_controller = $this->_getPluginControllerName($ctrlName);
            }

            foreach ($methods as $k => $method) {
                if (strpos($method, '_', 0) === 0) {
                    unset($methods[$k]);
                    continue;
                }
                if (in_array($method, $baseMethods)) {
                    unset($methods[$k]);
                    continue;
                }
            }

            foreach ($methods as $m) {
                $nome_controller = preg_replace('/^(.+)Controller$/', '\\1', $nome_controller);
                $controller = Inflector::underscore($nome_controller);
                $plugin = Inflector::underscore($nome_plugin);
                if (empty($plugin)) {
                    $plugin = null;
                }
                $urls[] = array(
                    'plugin' => $plugin,
                    'controller' => $controller,
                    'action' => $m
                );
            }
        }

        return $urls;
    }

    private function listarControllers() {
        $controllers = $this->getControllers();
        if (array_search('AppController', $controllers) !== false) {
            unset($controllers[array_search('AppController', $controllers)]);
        }
        $plugins = $this->_getPluginControllerNames();
        $controllers = array_merge($controllers, $plugins);
        return $controllers;
    }

    private function _getPluginControllerNames() {
        $plugins = Plugin::loaded();
        $ignoreList = [
            'Migrations',
            'DebugKit',
            'Bake'
        ];
        $controllers = array();
        foreach ($plugins as $plugin) {
            if (!in_array($plugin, $ignoreList)) {
                $controllers2 = $this->getControllers($plugin);
                foreach ($controllers2 as $k => $v) {
                    if ($v != ($plugin . 'AppController')) {
                        $controllers[] = $plugin . '.' . $v;
                    }
                }
            }
        }
        return $controllers;
    }

    public function existeUrl($url, $urls) {
        foreach ($urls as $url2) {
            $existe = $url2['plugin'] == $url['plugin'] &&
                    $url2['controller'] == $url['controller'] &&
                    $url2['action'] == $url['action'];
            if ($existe) {
                return true;
            }
        }
        return false;
    }

    /*private function _getClassMethods($ctrlName = null) {
        $controller = $ctrlName;
        if (strlen(strstr($ctrlName, '.')) > 0) {
            list($plugin, $controller) = explode('.', $ctrlName);
            App::uses($plugin . 'AppController', $plugin . '.Controller');
            App::uses($controller, $plugin . '.Controller');
        } else {
            App::uses($ctrlName, 'Controller');
        }
        $methods = get_class_methods($controller);
        return $methods;
    }*/
    
    private function _getClassMethods($controllerName, $controllerBase = false) {
        if (strlen(strstr($controllerName, '.')) > 0) {
            list($plugin, $controller) = explode('.', $controllerName);
            $className = $plugin . '\\Controller\\'.$controller.'Controller';
        } else {
           $className = 'App\\Controller\\'.$controllerName.'Controller';
        }
        $class = new ReflectionClass($className);
        $actions = $class->getMethods(ReflectionMethod::IS_PUBLIC);
        $results = [];
        $ignoreList = !$controllerBase ? ['beforeFilter', 'afterFilter', 'initialize', 'beforeSave'] : [];
        foreach ($actions as $action) {
            if ($action->class == $className && !in_array($action->name, $ignoreList)) {
                array_push($results, $action->name);
            }
        }
        return $results;
    }
    
    public function getControllers($plugin = null) {
        $pastaControllers = App::path('Controller');
        $pastaPluginController = dirname(APP) . DS . 'plugins' . DS . $plugin . DS . 'src' . DS . 'Controller';       
        $files = empty($plugin) ? scandir($pastaControllers[0]) : scandir($pastaPluginController);

        $results = [];
        $ignoreList = [
            '.',
            '..',
            'Component',
            'AppController.php',
        ];
        foreach ($files as $file) {
            if (!in_array($file, $ignoreList)) {
                $controller = explode('.', $file)[0];
                array_push($results, str_replace('Controller', '', $controller));
            }
        }

        return $results;
    }

    private function _isPlugin($ctrlName) {
        return strpos($ctrlName, '.') !== false;
    }

    private function _getPluginName($ctrlName = null) {
        list($plugin, $con) = explode('.', $ctrlName);
        return $plugin;
    }

    private function _getPluginControllerName($ctrlName = null) {
        list($plugin, $con) = explode('.', $ctrlName);
        return $con;
    }

    public function getUrlsNovas() {
        return $this->urlsNovas;
    }

    public function getUrlsRemovidas() {
        return $this->urlsRemovidas;
    }

}
