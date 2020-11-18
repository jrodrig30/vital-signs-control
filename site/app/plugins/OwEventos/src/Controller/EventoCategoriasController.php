<?php
namespace OwEventos\Controller;

use OwEventos\Lib\OwEventosUtil;
use OwEventos\Controller\OwEventosAppController;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;

class EventoCategoriasController extends OwEventosAppController {

    public function index() {
        $this->EventoCategorias->recursive = -1;
        $categorias = $this->Paginator->paginate($this->EventoCategorias);
        foreach($categorias as $categoria){
            $id = $categoria['id'];
            $categoria['nome'] = $this->EventoCategorias->getNomeFull($id);
        }
        $this->set('eventoCategorias', $categorias);
    }

    public function view($id = null) {
        if (!$id) {
            $this->Flash->error(__d('ow_eventos', 'Invalid evento categoria'));
            return $this->redirect(['action' => 'index']);
        }
        $categoria = $this->EventoCategorias->get($id);
        $categoria['nome'] = $this->EventoCategorias->getNomeFull($id);
        $this->set('eventoCategoria', $categoria);        
    }

    public function add() {
        $eventoCategoria = $this->EventoCategorias->newEntity();
        if ($this->request->is('post')) {
            $eventoCategoria = $this->EventoCategorias->patchEntity($eventoCategoria, $this->request->data);
            if ($this->EventoCategorias->save($eventoCategoria)) {
                $this->Flash->success(__('Categoria cadastrada com Sucesso!'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('Categoria não Cadastrada. Tente, novamente.'));
            }
        }
        $eventoCategorias = $this->EventoCategorias->listarTodas();
        $this->set(compact('eventoCategorias'));
    }

    public function edit($id = null) {
        $categoria = $this->EventoCategorias->get($id);
        if ($this->request->is(['post', 'put'])) {
            $this->EventoCategorias->patchEntity($categoria, $this->request->getData());
            if ($this->EventoCategorias->save($categoria)) {
                $this->Flash->success(__('Categoria salva com Sucesso.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Evento não pôde ser atualizado.'));
        }
        $this->set('categoria', $categoria);
        $eventoCategorias = $this->EventoCategorias->listarTodas();
        $this->set(compact('eventoCategorias'));
    }

    public function delete($id = null) {
        if (!$id) {
            $this->Flash->error(__d('ow_eventos', 'Invalid id for evento categoria'));
            return $this->redirect(['action' => 'index']);
        }
        $categoria = $this->EventoCategorias->get($id);
        $result = $this->EventoCategorias->delete($categoria);
        if ($result) {
            $this->Flash->success(__('Categoria removida com Sucesso!'));
            return $this->redirect(['action' => 'index']);
        }
        $this->Flash->error(__d('ow_eventos', 'Categoria não removida.'));
        return $this->redirect(['action' => 'index']);
    }

}
