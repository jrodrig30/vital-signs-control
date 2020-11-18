<?php
namespace OwEventos\Controller;

use OwEventos\Lib\OwEventosUtil;
use OwEventos\Controller\OwEventosAppController;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
use Cake\Core\Exception\Exception;

class EventosController extends OwEventosAppController {

    public function index() {
        $this->set('eventos', $this->Paginator->paginate($this->Eventos));
    }

    public function view($id = null) {
        if (!$id) {
            $this->Flash->error(__d('ow_eventos', 'Evento inválido'));
            return $this->redirect(['action' => 'index']);
        }
        $evento = $this->Eventos->get($id);
        $this->set('evento', $evento);
    }

    public function add() {
        $evento = $this->Eventos->newEntity();
        if ($this->request->is('post')) {
            $evento = $this->Eventos->patchEntity($evento, $this->request->data);
            if ($this->Eventos->save($evento)) {
                $this->Flash->success(__('Evento cadastrado com Sucesso!'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('Evento não Cadastrado. Tente, novamente.'));
            }
        }
        $this->set('eventoCategorias', $this->Eventos->EventoCategorias->listarNosFolha());
    }

    public function edit($id = null) {
        $evento = $this->Eventos->get($id);
        if ($this->request->is(['post', 'put'])) {
            $this->Eventos->patchEntity($evento, $this->request->getData());
            if ($this->Eventos->save($evento)) {
                $this->Flash->success(__('Evento salvo com Sucesso.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Evento não pôde ser atualizado.'));
        }
        $this->set('evento', $evento);
        TableRegistry::get('OwEventos.Eventos');
        TableRegistry::get('OwEventos.EventoCategorias');
        $this->set('eventoCategorias', $this->Eventos->EventoCategorias->listarNosFolha());
    }
    
    public function cancelar_destaques(){
        try{
            $this->Eventos->cancelarDestaques();
            $this->Flash->success(__('Destaques Cancelados!'));
        }catch(Exception $e){
            $this->Flash->error(__($e->getMessage()));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function delete($id = null) {
        if (!$id) {
            $this->Flash->error(__d('ow_eventos', 'Evento inválido'));
            return $this->redirect(['action' => 'index']);
        }
        $evento = $this->Eventos->get($id);
        $result = $this->Eventos->delete($evento);
        if ($result) {
            $this->Flash->success(__('Evento removido com Sucesso!'));
            return $this->redirect(['action' => 'index']);
        }
        $this->Flash->error(__d('ow_eventos', 'Evento não foi deletado.'));
        return $this->redirect(['action' => 'index']);
    }
}
