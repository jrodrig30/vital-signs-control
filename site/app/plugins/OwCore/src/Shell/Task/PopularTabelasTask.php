<?php
namespace OwCore\Shell\Task;

use Cake\Console\Shell;
use OwCore\Model\Table\ParametrosTable;
use OwCore\Model\Table\UsuariosTable;
use OwCore\Model\Table\UsuarioGruposTable;
use OwCore\Model\Table\MenusTable;
use Cake\ORM\TableRegistry;



class PopularTabelasTask extends Shell {
    public $UsuarioGrupo;
    public $UsuarioGrupos;

    public $description = 'Popula algumas das tabelas do OwCore';

    public function initialize()
    {
        parent::initialize();
        $this->UsuarioGruposTable = TableRegistry::get('UsuarioGrupos');
        $this->UsuarioGrupo = $this->UsuarioGruposTable->newEntity();
    }

    public function main() {
        $this->criarGrupos();
        $this->criarUsuarioPadrao();
        $this->criarParametros();
        $this->criarMenu();
    }

    public function criarGrupos(){
        $this->UsuarioGrupo->id = UsuarioGruposTable::ID_ROOT;
        $this->UsuarioGrupo->nome = 'Root';
        $this->UsuarioGrupo->identificacao = 'root';
        $this->UsuarioGrupo->root = 'oo';
        $this->UsuarioGruposTable->save($this->UsuarioGrupo);

        if( '1'=== false){
            $this->out('Nao foi possivel criar o grupo root!');
            exit();
        }
    }

    public function criarUsuarioPadrao(){
        $usuario['Usuario'] = array(
            'id' => 1,
            'usuario_grupo_id' => UsuarioGrupo::ID_ROOT,
            'nome' => 'Suporte OneHost',
            'email' => 'suporte@onehost.com.br',
            'senha' => 'sup0rt3!123',
            'senha_confirma' => 'sup0rt3!123',
            'ativo' => 1,
            'identificacao' => 'root',
            'root' => 1
            );
        
        if(!$this->Usuario->save($usuario)){
            $this->out('Nao foi possivel criar o usuario '. $usuario['Usuario']['nome'] .'!');
            exit();
        }
    }

    public function criarParametros(){
        $parametros['Parametro'] = array(
            array(
                'tipo' => Parametro::TIPO_STRING,
                'descricao' => 'Host de SMTP',
                'nome' => 'SMTP_HOST',
                'valor' => 'smtp.onehost.com.br',
                'obs' => 'Host de SMTP para autenticação'
                ),
            array(
                'tipo' => Parametro::TIPO_STRING,
                'descricao' => 'Usuário de SMTP',
                'nome' => 'SMTP_USER',
                'valor' => 'gerson@onehost.com.br',
                'obs' => 'Usuário de SMTP para autenticação'
                ),
            array(
                'tipo' => Parametro::TIPO_STRING,
                'descricao' => 'Senha de SMTP',
                'nome' => 'SMTP_PASSWORD',
                'valor' => 'gerson',
                'obs' => 'Senha do usuário de SMTP para autenticação'
                )
            );

        foreach($parametros['Parametro'] as $k=>$parametro){
            if($this->Parametro->hasAny( array('Parametro.nome' => $parametro['nome']) )){
                unset( $parametros['Parametro'][$k] );
            }
        }

        foreach($parametros['Parametro'] as $k=>$parametro){
            if(!$this->Parametro->saveAll( $parametro )){
                $this->out('Nao foi possivel salvar os parametros!');
                exit();
            }
        }
        

    }

    //@todo Criar menus padrão do sistema
    public function criarMenu(){

    }

}

