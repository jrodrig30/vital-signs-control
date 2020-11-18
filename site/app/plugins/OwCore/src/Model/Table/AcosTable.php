<?php

namespace OwCore\Model\Table;

use OwCore\Model\Table\AppTable;
use Cake\ORM\Table;
use Cake\ORM\Entity;
use Cake\Validation\Validator;
use Cake\ORM\Query;

class AcosTable extends Table {

    const TIPO_URL = 'U';
    const TIPO_OBJETO = 'O';

    public function initialize(array $config) {
        $this->table('acos');
        $this->primaryKey('id');
    }

    public function validationDefault(Validator $validator) {
        $validator
                ->integer('id')
                ->allowEmpty('id', 'create');

        $validator
                ->requirePresence('tipo', 'create')
                ->notEmpty('tipo');

        $validator
                ->allowEmpty('plugin');

        $validator
                ->allowEmpty('controller');

        $validator
                ->allowEmpty('action');

        $validator
                ->allowEmpty('objeto');

        return $validator;
    }

    public static function getTipoUrl() {
        return self::TIPO_URL;
    }

    public static function getTipoObjeto() {
        return self::TIPO_OBJETO;
    }

    public static function getTipoObjetos() {
        return array(
            self::TIPO_URL => 'URL',
            self::TIPO_OBJETO => 'OBJETO'
        );
    }

    public static function getNomeTipoObjeto($tipo) {
        $tipos = self::getTipoObjetos();
        return $tipos[$tipo];
    }

    public static function isTipoUrl($aco) {
        return $aco['tipo'] == self::getTipoUrl();
    }

    public static function isTipoObjeto($aco) {
        return $aco['tipo'] == self::getTipoObjeto();
    }

    public function getUrls() {
        $query = $this->find('all', array('conditions' => 'tipo = "' . self::getTipoUrl() . '"'));
        $urls = $query->all();
        $r = array();
        foreach ($urls as $url) {
            $r[] = array(
                'plugin' => $url->plugin,
                'controller' => $url->controller,
                'action' => $url->action,
            );
        }
        return $r;
    }

    public function montaAcoByUrl($url) {
        return array(
            'tipo' => self::getTipoUrl(),
            'plugin' => $url['plugin'],
            'controller' => $url['controller'],
            'action' => $url['action']
        );
    }

    public function existeUrl($url) {

        $query = $this->find('all', [
            'conditions' => [
                'controller' => $url['controller'],
                'action' => $url['action'],
                'OR' => [
                    'plugin' => $url['plugin'],
                    'plugin IS NULL'
                ]
            ]
        ]);

        $dados = $query->all();
        if ($dados->isEmpty()) {
            return false;
        }

        return true;
    }

    public function salvarUrl($url) {
        $aco = $this->newEntity();
        if (!$this->existeUrl($url)) {
            $aco = $this->patchEntity($aco, $this->montaAcoByUrl($url));
            return $this->save($aco);
        }

        return true;
    }

    public function removerUrl($url) {
        $cond = array(
            'tipo' => self::getTipoUrl(),
            'plugin' => $url['plugin'],
            'controller' => $url['controller'],
            'action' => $url['action']
        );

        return $this->deleteAll($cond);
    }

    public function getAllAcosLeftJoinPermissaoByGrupo($grupo_id, $tipo = null) {

        $sql = "SELECT Aco.*, Permissao.*  ";
        $sql .= "FROM acos Aco LEFT JOIN permissoes Permissao ";
        $sql .= "ON Aco.id = Permissao.aco_id and Permissao.usuario_grupo_id = " . $grupo_id . " ";
        if ($tipo != null) {
            $sql .= " WHERE Aco.tipo = '" . $tipo . "' ";
        }
        $sql .= "ORDER BY Aco.plugin, Aco.controller, Aco.action";
        return $this->query($sql);
    }

}

?>