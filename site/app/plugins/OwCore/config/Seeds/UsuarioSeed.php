<?php

use Migrations\AbstractSeed;
use \OwCore\Model\Table\UsuarioGruposTable;
/**
 * Usuario seed.
 */
class UsuarioSeed extends AbstractSeed {

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
                'id' => 1,
                'usuario_grupo_id' => UsuarioGruposTable::ID_ROOT,
                'nome' => 'Suporte OneHost',
                'email' => 'suporte@onehost.com.br',
                'senha' => crypt('sup0rt3!123'),
                'ativo' => 1,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s')
            )
        ];

        $table = $this->table('usuarios');
        $table->insert($data)->save();
    }

}
