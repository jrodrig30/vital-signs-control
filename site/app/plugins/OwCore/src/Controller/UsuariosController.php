<?php
namespace OwCore\Controller;

use OwCore\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use \Exception;

class UsuariosController extends AppController {

    public $helpers = array('Html', 'Form','OwCore.OwHtml');
    public $uses = array('OwCore.Usuario', 'OwCore.NovaSenha', 'OwCore.TrocarSenha');
    //public $components = array('OwCore.OwEmail');

    public function beforeFilter(Event $event) {
        $this->Main->allow('*');
        $this->Main->autorizarUrl('/ow_core/usuarios/login');
        $this->Main->autorizarUrl('/ow_core/usuarios/recuperar_senha');
        $this->viewBuilder()->layout('login');
        parent::beforeFilter($event);
    }

    public function index() {
        $this->Usuarios->recursive = 0;
        $this->set('usuarios', $this->Paginator->paginate($this->Usuarios));
    }

    public function view($id = null) {
        if (!$id) {
            $this->Flash->set(__('Usuário inválido.'));
            $this->redirect(array('action' => 'index'));
        }
        
        $this->set('usuario', $this->Usuario->read(null, $id));
    }
    
    public function meus_dados(){
        $usuario = $this->Main->getUsuarioLogado();
        $this->set('usuario', $usuario);
    }

    public function add() {
        if (!empty($this->request->data)) {
            $this->Usuario->create();
            if ($this->Usuario->save($this->request->data)) {
                $this->Flash->set(__('O usuário foi salvo'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->request->data['Usuario']['senha'] = $this->request->data['Usuario']['senha_confirma'] = '';
                $this->Flash->set(__('O usuário não pode ser salvo. Por favor, tente novamente.'));
            }
        }
        $this->set('ow_grupos', $this->Usuario->UsuarioGrupo->find('list'));
    }

    public function edit($id = null) {
        if (!$id && empty($this->request->data)) {
            $this->Flash->set(__('Usuário inválido'));
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->request->data)) {
            if ($this->Usuario->save($this->request->data)) {
                $this->Flash->set(__('O usuário foi salvo'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->set(__('O usuário não pode ser salvo. Por favor, tente novamente.'));
                $this->request->data['Usuario']['senha'] = $this->request->data['Usuario']['senha_confirma'] = '';
            }
        }
        if (empty($this->request->data)) {
            $this->request->data = $this->Usuario->read(null, $id);
            $this->request->data['Usuario']['senha'] = '';
        }

        $this->set('ow_grupos', $this->Usuario->UsuarioGrupo->find('list'));
    }

    public function delete($id = null) {
        if (!$id) {
            $this->Flash->set(__('Usuário inválido'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->Usuario->delete($id)) {
            $this->Flash->set(__('Usuário removido'));
        }

        $this->redirect(array('action' => 'index'));
    }

    public function trocar_minha_senha(){
        $id = $this->_getUsuarioId();
        if(!empty($this->request->data)){
            $ts = TableRegistry::get('OwCore.TrocarSenhas');
            $trocarSenha = $ts->newEntity();
            $validaSenha = $trocarSenha->checaSenhaIguais($this->request->data);
            if($validaSenha){
                try{
                    $this->Usuarios->trocarSenha($id, $this->request->data['senha']);
                    $this->Flash->success(__('Senha alterada com sucesso!'));
                    $this->request->data = array();
                    return $this->redirect(['action' => 'meus_dados']);
                }catch(Exception $e){
                    $this->Flash->error(__('Não foi possível trocar a senha!'));
                }
            } else {
                $this->Flash->error(__('As duas senhas devem ser iguais!'));
            }
        }
    }

    public function recuperar_senha() {

        if (!empty($this->request->data)) {

            $this->NovaSenha->set($this->request->data);
            if ($this->NovaSenha->validates()) {
                $usuario = $this->Usuario->find('first', array('conditions' => array('email' => $this->request->data['NovaSenha']['email'])));
                if ($usuario) {
                    $novaSenha = $this->Usuario->getSenhaAleatoria();
                    $this->OwEmail->AddAddress($usuario['Usuario']['email']);
                    $this->OwEmail->SetSubject("Troca de senha");
                    $mensagem = "Olá " . $usuario['Usuario']['nome'] . "<br /><br />";
                    $mensagem .= "Sua nova senha para acessar o sistema é: " . $novaSenha;
                    $this->OwEmail->SetFrom('suporte@onehost.com.br');
                    $this->OwEmail->SetBody($mensagem);
                    if ($this->OwEmail->Send()) {
                        try{
                            $this->Usuario->trocarSenha($usuario['Usuario']['id'], $novaSenha);
                        }catch(Exception $e){ }
                        $this->Flash->set(__('Sua nova senha foi enviada por email.'));
                    } else {
                        $this->Flash->set(__('Não foi possível enviar o email com a nova senha.'));
                    }
                } else {
                    $this->Flash->set(__('Email não encontrado.'));
                }
            }
        }
    }

    public function login() {
        if(!empty($this->request->data)){
            try{
                $email = $this->request->data['email'];
                $senha = $this->request->data['senha'];
                $user = $this->Main->getUsuarioValido($email, $senha);
                $arrayUser = $user->toArray();
                $this->Main->fazerLogin($arrayUser);
            }catch(Exception $e){
                $this->Flash->set($e->getMessage());
            }
        }
    }

    public function logout() {
        $this->Main->fazerLogout();
    }

}