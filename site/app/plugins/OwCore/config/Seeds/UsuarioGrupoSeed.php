<?php

use Migrations\AbstractSeed;
use \OwCore\Model\Table\UsuarioGruposTable;
/**
 * UsuarioGrupo seed.
 */
class UsuarioGrupoSeed extends AbstractSeed {

    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     *
     * @return void
     */
    public function run() {
        $data = [
            array(
                'id' => UsuarioGruposTable::ID_ROOT,
                'nome' => 'Root',
                'identificacao' => 'root',
                'root' => 1,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s')
            )
        ];


        $table = $this->table('usuario_grupos');
        $table->insert($data)->save();
    }

}
