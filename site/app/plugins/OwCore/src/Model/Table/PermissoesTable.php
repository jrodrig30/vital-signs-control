<?php
namespace OwCore\Model\Table;

class PermissoesTable extends AppTable {
        public $useTable = 'permissoes';

        function getPermissoesDoGrupo($usuario_grupo_id){
            if(!strlen($usuario_grupo_id)){
                return array();
            }
            
            $sql  = "SELECT Permissao.*, Aco.*  ";
            $sql .= "FROM acos Aco, ";
            $sql .= "permissoes Permissao ";
            $sql .= "WHERE Permissao.aco_id = Aco.id AND ";
            $sql .= "Permissao.usuario_grupo_id = " . $usuario_grupo_id . " ";
            $sql .= "ORDER BY Aco.plugin, Aco.controller, Aco.action";

            return $this->query($sql);
        }

        public static function marcouAco($permissao){
            return $permissao['aco_id'] != 0;
        }
        
        public static function deveRemoverPermissao($permissao){
            return ( !self::marcouAco($permissao) ) && self::permissaoExiste($permissao);
        }

        public static function permissaoExiste($permissao){
            return isset($permissao['id']);
        }

        public static function deveCriarPermissao($permissao){
            return self::marcouAco($permissao) && !self::permissaoExiste($permissao);
        }

        public function limparCache($usuario_grupo_id){
            App::import('Lib','OwCore.PermissaoLib');
            return PermissaoLib::removeCache( $usuario_grupo_id );
        }

        public function salvarPermissoes($dados){
            $this->begin();
            foreach($dados['Permissao'] as $permissao){
                if(self::deveRemoverPermissao($permissao)){
                    if(!$this->delete( $permissao['id'] )){
                        $this->rollback();
                        throw new Exception('Não foi possível remover a permissão!');
                    }
                }

                if(self::deveCriarPermissao($permissao)){
                    $this->create();
                    if(!$this->save($permissao)){
                        $this->rollback();
                        throw new Exception('Não foi possível criar a permissão!');
                    }
                }
            }
            $this->commit();
        }
}
?>