<?php

namespace App\Controller;

use App\Controller\AppController;

/**
 * Users Controller
 *
 * @property \OwBusca\Controller\Component\OwBuscaComponent $OwBusca
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController {

    public $components = ['OwBusca.OwBusca'];

    /**
     * Index method
     *
     * @return void
     */
    public function initialize() {

        parent::initialize();
    }

    public function index() {
        $this->OwBusca->setConfig($this->_getConfig());
        $this->paginate = [
            'Users' => [
                'conditions' => $this->OwBusca->getCondicoes(['Users.nome' => 'F'])
            ]
        ];

        $this->set('users', $this->paginate($this->Users));
        $this->set('_serialize', ['users']);
    }
    
    public function index2() {
        $this->OwBusca->setConfig(['campos' => ['Users.nome' => ['label' => 'Nome']]]);
        $this->paginate = [
            'Users' => [
                'conditions' => $this->OwBusca->getCondicoes(['Users.nome' => 'F'])
            ]
        ];

        $this->set('users', $this->paginate($this->Users));
        $this->set('_serialize', ['users']);
        $this->render('index');
    }
    
    private function _getConfig() {
        return [
            'campos' => [
                'Users.nome' => [
                    'label' => 'Nome'
                ],
                'Users.nome OR Users.sobrenome' => [
                    'label' => 'Nome ou Sobrenome'
                ],
                'Users.sobrenome' => [
                    'label' => 'Sobrenome'
                ],
                'Users.idade' => [
                    'label' => 'Idade'
                ],
                'Users.data_nascimento' => [
                    'label' => 'Data Nascimento'
                ],
                'Users.data_cadastro' => [
                    'label' => 'Data Cadastro'
                ]
            ],
            'limit' => false,
            //'buscarOnChangeSelect' => true,
            //'trimTodosCampos' => false
        ];
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null) {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        $this->set('user', $user);
        $this->set('_serialize', ['user']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->success('The user has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The user could not be saved. Please, try again.');
            }
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->success('The user has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The user could not be saved. Please, try again.');
            }
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success('The user has been deleted.');
        } else {
            $this->Flash->error('The user could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }

}
