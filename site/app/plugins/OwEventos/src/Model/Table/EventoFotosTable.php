<?php
namespace OwEventos\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use Cake\Event\Event;
use Cake\Core\Exception\Exception;

class EventoFotosTable extends Table {
    
    public function initialize(array $config) {
        $this->table('evento_fotos');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->addBehavior('Timestamp');
        $this->addBehavior('Josegonzalez/Upload.Upload', [
            'arquivo' => [
                'path' => 'uploads{DS}eventos{DS}{field-value:evento_id}',
                'fields' => [
                    'dir' => 'photo_dir',
                    'size' => 'photo_size',
                    'type' => 'photo_type',
                ],
                'filesystem' => ['root' => PUBLIC_HTML],
            ],
        ]);
        $this->belongsTo('Eventos', [
            'foreignKey' => 'evento_id',
            'joinType' => 'INNER',
            'className' => 'OwEventos.Eventos'
        ]);
    }
    
    public function validationDefault(Validator $validator) {
        $validator
                ->add('id', 'valid', ['rule' => 'numeric'])
                ->allowEmpty('id', 'create')
                ->add('evento_id', 'valid', ['rule' => 'numeric'])
                ->allowEmpty('evento_id', 'create')
                ->add('ordem', 'valid', ['rule' => 'numeric'])
                ->allowEmpty('ordem', 'create')
                ->requirePresence('arquivo', 'create')
                ->notEmpty('arquivo');
        return $validator;
    }

    public $order = 'EventoFoto.ordem ASC, EventoFoto.id DESC';
    
    public function adicionarPorArquivoZip($dados) {
        
        /*if (!$this->validates()) {
            throw new Exception('Corrija os erros abaixo!');
        }*/

        $destino = TMP . 'fotos.zip';

        if (file_exists($destino)) {
            unlink($destino);
        }

        if (!move_uploaded_file($dados['arquivo_zip']['tmp_name'], $destino)) {
            throw new Exception('Não foi possível mover o arquivo!');
        }

        //limpa a pasta
        $arquivosAntigos = glob(TMP . 'fotos' . DS . '*.*');
        foreach ($arquivosAntigos as $f) {
            unlink($f);
        }

        $zip = new \ZipArchive();
        $res = $zip->open($destino);
        if ($res !== TRUE) {
            unlink($destino);
            throw new Exception('Não foi possível abrir o arquivo zip!');
        }
        
        $zip->extractTo(TMP . 'fotos' . DS);
        $zip->close();
        unlink($destino);
        
        $dir = TMP . 'fotos' . DS;
        $pasta= opendir($dir);
        $i=0;
        while ($arquivo = readdir($pasta)){
            if ($arquivo != '.' && $arquivo != '..'){
                $sub_pastas[$i] = $arquivo;
                $i += 1;
            }
        }
        
        $fotos[0] = glob(TMP . 'fotos' . DS . '*.*');
        $k=1;
        if(!empty($sub_pastas)){
            foreach ($sub_pastas as $sub_pasta){

                $fotos[$k] = glob(TMP . 'fotos' . DS . $sub_pasta . DS . '*.*');
                $k += 1;
            }
        }

        //ajustar fotos 1 por indice
        $j=0;
        foreach ($fotos as $foto) {
            foreach ($foto as $f){
               $ajustarFotos[$j] = $f;
               $j += 1;
            }
        }

        foreach ($ajustarFotos as $foto) {
            $salvar = [
                'evento_id' => $dados['evento_id'],
                'arquivo' => [
                    'name' => basename($foto),
                    'type' => 'image/jpeg',
                    'tmp_name' => $foto,
                    'error' => (int) 0,
                    'size' => (int) filesize($foto)
                ],
                'pasta' => $dados['GaleriaFoto']['pasta'],
            ];
            
            $evento = TableRegistry::get('OwEventos.EventoFotos');
            $evento = $this->newEntity();
            $evento = $this->patchEntity($evento, $salvar);
            
            if (!$this->save($evento)) {
                throw new Exception('Não foi possível salvar a foto ' . basename($foto));
            }

            unlink($foto);
        }
    }
}
