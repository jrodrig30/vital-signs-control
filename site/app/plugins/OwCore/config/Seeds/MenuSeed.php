<?php

use Migrations\AbstractSeed;

/**
 * Menu seed.
 */
class MenuSeed extends AbstractSeed {

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
                'nome' => 'Sistema',
                'ordem' => 900,
            ),
            array(
                'menu_id' => 1,
                'nome' => 'Trocar Minha Senha',
                'plugin' => 'ow_core',
                'controller' => 'usuarios',
                'action' => 'trocar_minha_senha',
                'ordem' => 200,
            ),
            array(
                'menu_id' => 1,
                'nome' => 'Meus Dados',
                'plugin' => 'ow_core',
                'controller' => 'usuarios',
                'action' => 'meus_dados',
                'ordem' => 300,
            ),
            array(
                'menu_id' => 1,
                'nome' => 'Usuários',
                'plugin' => 'ow_core',
                'controller' => 'usuarios',
                'action' => 'index',
                'ordem' => 400,
            ),
            array(
                'menu_id' => 1,
                'nome' => 'Parâmetros',
                'plugin' => 'ow_core',
                'controller' => 'parametros',
                'action' => 'index',
                'ordem' => 500,
            ),
            array(
                'menu_id' => 1,
                'nome' => 'Menus',
                'plugin' => 'ow_core',
                'controller' => 'menus',
                'action' => 'index',
                'ordem' => 600,
            ),
            array(
                'menu_id' => 1,
                'nome' => 'Acos',
                'plugin' => 'ow_core',
                'controller' => 'acos',
                'action' => 'index',
                'ordem' => 700,
            ),
            array(
                'menu_id' => 1,
                'nome' => 'Grupos',
                'plugin' => 'ow_core',
                'controller' => 'usuario_grupos',
                'action' => 'index',
                'ordem' => 800,
            ),
            array(
                'menu_id' => 1,
                'nome' => 'Sair',
                'plugin' => 'ow_core',
                'controller' => 'usuarios',
                'action' => 'logout',
                'ordem' => 900,
            )
        ];

        $table = $this->table('menus');
        $table->insert($data)->save();
    }

}
