<?php
namespace OwEventos\Controller;

use OwEventos\Lib\OwEventosUtil;
use Cake\ORM\Table;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use Cake\Event\Event;

class EventoFotosController extends OwEventosAppController {

    public function index() {
        $this->EventoFotos->recursive = 0;
        $this->set('eventoFotos', $this->paginate());
    }

    public function view($id = null) {
        if (!$id) {
            $this->Flash->error(__d('ow_eventos', 'Foto inválida'));
            return $this->redirect(['action' => 'index']);
        }
        $eventoFoto = $this->EventoFotos->get($id);
        $this->set('eventoFoto', $eventoFoto);
    }

    public function add() {
        $foto = $this->EventoFotos->newEntity();
        if ($this->request->is('post')) {
            $foto = $this->EventoFotos->patchEntity($foto, $this->request->data);
            if ($this->EventoFotos->save($foto)) {
                $this->Flash->success(__('Foto cadastrada com Sucesso!'));
                return $this->redirect(['controller' => 'eventos', 'action' => 'index']);
            } else {
                $this->Flash->error(__('Foto não Cadastrada. Tente, novamente.'));
            }
        }
        $this->set('foto', $this->request->params['?']['evento_id']);
    }
    
    public function add_zip() {
        $foto = $this->EventoFotos->newEntity();
        if (!empty($this->request->data)) {
            try {
                $this->EventoFotos->Eventos->id = $this->request->params['?']['evento_id'];
                $this->request->data['GaleriaFoto']['pasta'] = $this->EventoFotos->Eventos->id;
                $this->EventoFotos->adicionarPorArquivoZip($this->request->data);
                $this->Flash->success(__('As fotos foram salvas com sucesso!'));
                return $this->redirect(['controller' => 'eventos', 'action' => 'index']);
            } catch (Exception $e) {
                $this->Flash->error(__d('ow_galerias', $e->getMessage()));
            }
        }
        $this->set('foto', $this->request->params['?']['evento_id']);
    }

    public function edit($id = null) {
        $foto = $this->EventoFotos->get($id);
        if ($this->request->is(['post', 'put'])) {
            $this->EventoFotos->patchEntity($foto, $this->request->getData());
            if ($this->EventoFotos->save($foto)) {
                $this->Flash->success(__('Foto salvo com Sucesso.'));
                return $this->redirect(['controller' => 'eventos', 'action' => 'index']);
            }
            $this->Flash->error(__('Foto não pôde ser atualizado.'));
        }
        $this->set('foto', $foto);
    }

    public function delete($id = null) {
        if (!$id) {
            $this->Flash->error(__d('ow_eventos', 'Foto inválida'));
            return $this->redirect(['controller' => 'eventos', 'action' => 'index']);
        }
        
        $eventoFoto = $this->EventoFotos->get($id);
        $result = $this->EventoFotos->delete($eventoFoto);
        if ($result) {
            $this->Flash->success(__('Foto removida com Sucesso!'));
            return $this->redirect(['controller' => 'eventos', 'action' => 'index']);
        }
        $this->Flash->error(__d('ow_eventos', 'Foto não deletada.'));
        return $this->redirect(['controller' => 'eventos', 'action' => 'index']);
    }

}
