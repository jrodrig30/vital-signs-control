<?php

namespace OwCore\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;
use Cake\Cache\Cache;

class MenusTable extends Table {
    /* public $name = 'Menu';
      public $displayField = 'nome';
      public $order = 'Menu.ordem'; */

    public function initialize(array $config) {

        $this->setTable('menus');
        $this->setDisplayField('nome');
        $this->setPrimaryKey('id');

        $this->belongsTo('MenuPai', [
            'className' => 'OwCore.Menu',
            'foreignKey' => 'menu_id'
        ]);
        $this->hasMany('MenuFilho', [
            'foreignKey' => 'menu_id',
            'sort' => ['MenuFilho.ordem' => 'ASC']
        ]);
    }

    public function validationDefault(Validator $validator) {
        $validator
                ->integer('id')
                ->allowEmpty('id', 'create');

        $validator
                ->requirePresence('nome', 'create')
                ->notEmpty('nome');

        $validator
                ->allowEmpty('plugin');

        $validator
                ->allowEmpty('controller');

        $validator
                ->allowEmpty('action');

        $validator
                ->integer('ordem')
                ->requirePresence('ordem', 'create')
                ->notEmpty('ordem');

        $validator
                ->boolean('ativo')
                ->requirePresence('ativo', 'create')
                ->notEmpty('ativo');

        return $validator;
    }

    public function buildRules(RulesChecker $rules) {
        $rules->add($rules->existsIn(['menu_id'], 'Menus'));

        return $rules;
    }

    public function getSubMenus($menu_id) {
        $this->recursive = -1; //verificar
        $query = $this->find('all', ['conditions' => ['Menus.menu_id' => $menu_id, 'Menus.ativo' => 1]]);
        
        $subs = $query->all();
        
        $subsArray = $subs->toArray();
        foreach ($subsArray as &$sub) {
            $f = $this->getSubMenus($sub['id']);
            if (!count($f)) {
                continue;
            }
            $sub['SubMenus'] = $f;
        }
        return $subsArray;
    }

    public function afterSave($created, $options = array()) {
        $this->limparCacheFullMenu();
        return parent::afterSave($created);
    }

    public function afterDelete() {
        $this->limparCacheFullMenu();
        return parent::afterDelete();
    }

    public function limparCacheFullMenu() {
        Cache::set(array('duration' => '+30 days'));
        return Cache::delete('ow_menu');
    }

    public function getFullMenuCache() {
        $Cache = Cache::engine('default');
        $Cache->setConfig('duration', '+30 days');

        return Cache::read('ow_menu');
    }

    public function writeFullMenuCache($fullMenu) {
        $Cache = Cache::engine('default');
        $Cache->setConfig('duration', '+30 days');
        return Cache::write('ow_menu', $fullMenu);
    }

    public function getMenusPrincipais() {
        $this->recursive = -1;
        $query = $this->find('all', ['conditions' => ['Menus.menu_id IS NULL', 'Menus.ativo' => 1], 'order' => 'Menus.ordem ASC']);
        $menus = $query->all();
        return $menus->toArray();
    }

    public function listaMenusPrincipais() {
        $lista = array();
        $menus = $this->getMenusPrincipais();
        foreach ($menus as $menu) {
            $lista[$menu[$this->name]['id']] = $menu[$this->name]['nome'];
        }
        return $lista;
    }

    public function listarNomeCompleto($separador = ' » ') {
        $menus = $this->find('all', array('recursive' => -1));
        foreach ($menus as &$menu) {
            $this->setarNomeCompleto($menu, $separador);
        }

        $lista = array();
        foreach ($menus as $m) {
            $id = $m[$this->alias]['id'];
            $nome = $m[$this->alias]['nome_completo'];
            $lista[$id] = $nome;
        }

        return $lista;
    }

    public function setarNomeCompleto(&$menu, $separador = ' » ') {
        $menu_pai = strlen($menu[$this->name]['menu_id']) ? $menu[$this->name]['menu_id'] : NULL;
        $menu[$this->name]['nome_completo'] = $menu[$this->name]['nome'];
        while ($menu_pai != NULL) {
            $dados = $this->findById($menu_pai);
            if (empty($dados)) {
                break;
            }
            $menu[$this->name]['nome_completo'] = $dados[$this->name]['nome'] . $separador . $menu[$this->name]['nome_completo'];
            $menu_pai = $dados[$this->name]['menu_id'];
        }
    }

    public function getFullMenu() {

        $menu = $this->getFullMenuCache();
        if ($menu != false) {
           return $menu;
        }

        $menus_principais = $this->getMenusPrincipais();

        foreach ($menus_principais as &$menu) {
            $f = $this->getSubMenus($menu['id']);
            if (!count($f)) {
                continue;
            }

            $menu['SubMenus'] = $f;
        }
        $this->writeFullMenuCache($menus_principais);
        return $menus_principais;
    }

}
