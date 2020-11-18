<?php
namespace OwCore\Controller;

use OwCore\Controller\AppController;
use OwCore\Lib\CarregaActionsLib;

class UsuarioGruposController extends AppController {

    public $uses = array('OwCore.UsuarioGrupo','OwCore.Aco','OwCore.Permissao');

    public function index() {
        $this->UsuarioGrupo->recursive = 0;
        $this->set('owGrupos', $this->Paginator->paginate());
    }

    public function view($id = null) {
        if (!$id) {
            $this->Flash->set(__('Invalid ow grupo'));
            $this->redirect(array('action' => 'index'));
        }
        $this->set('owGrupo', $this->UsuarioGrupo->read(null, $id));
    }

    public function tornar_root( $id ){
        $this->UsuarioGrupo->tornarRoot( $id );
        $this->Flash->set(__('Grupo setado como root!'));
        $this->redirect(array('action' => 'index'));
    }

    public function remover_root( $id ){
        $this->UsuarioGrupo->removerRoot( $id );
        $this->Flash->set(__('Root removido!'));
        $this->redirect(array('action' => 'index'));
    }

    public function setar_permissoes($id = null) {
        App::uses('Aco', 'OwCore.Model');
        if(!empty($this->request->data)){
            try{
                $this->Permissao->salvarPermissoes($this->request->data);
                $this->Permissao->limparCache($id);
                $this->Flash->set('Permissões salvas com sucesso!');
            }catch(Exception $e){
                $this->Flash->set($e->getMessage());
            }
        }

        $ow_acos = $this->Aco->getAllAcosLeftJoinPermissaoByGrupo( $id, Aco::TIPO_URL );
        $this->UsuarioGrupo->recursive = -1;
        $this->set('ow_grupo',$this->UsuarioGrupo->findById($id));
        $this->set('ow_acos',$ow_acos);
    }
    
    public function setar_permissoes_objetos($id = null) {
        App::uses('Aco', 'OwCore.Model');
        $ow_acos = $this->Aco->getAllAcosLeftJoinPermissaoByGrupo( $id, Aco::TIPO_OBJETO );
        $this->UsuarioGrupo->recursive = -1;
        $this->set('ow_grupo',$this->UsuarioGrupo->findById($id));
        $this->set('ow_acos',$ow_acos);
        
        $this->render('setar_permissoes');
    }

    public function add() {
        if (!empty($this->request->data)) {
            $this->UsuarioGrupo->create();
            if ($this->UsuarioGrupo->save($this->request->data)) {
                $this->Flash->set(__('The ow grupo has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->set(__('The ow grupo could not be saved. Please, try again.'));
            }
        }
    }

    public function edit($id = null) {
        if (!$id && empty($this->request->data)) {
            $this->Flash->set(__('Invalid ow grupo'));
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->request->data)) {
            if ($this->UsuarioGrupo->save($this->request->data)) {
                $this->Flash->set(__('The ow grupo has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->set(__('The ow grupo could not be saved. Please, try again.'));
            }
        }
        if (empty($this->request->data)) {
            $this->request->data = $this->UsuarioGrupo->read(null, $id);
        }
    }

    public function delete($id = null) {
        if (!$id) {
            $this->Flash->set(__('Invalid id for ow grupo'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->UsuarioGrupo->delete($id)) {
            $this->Flash->set(__('Ow grupo deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Flash->set(__('Ow grupo was not deleted'));
        $this->redirect(array('action' => 'index'));
    }
    
    public function carregar_urls() {
        $c = new CarregaActionsLib();
        $url = $c->atualizarCadastroUrls();
        $entra = $c->getUrlsNovas();
        $sai = $c->getUrlsRemovidas();  
        $this->set('entradas', $entra);
        $this->set('saidas', $sai);

    }
}