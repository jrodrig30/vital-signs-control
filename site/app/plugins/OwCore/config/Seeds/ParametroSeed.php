<?php

use Migrations\AbstractSeed;
use OwCore\Model\Table\ParametrosTable;
/**
 * Parametro seed.
 */
class ParametroSeed extends AbstractSeed {

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
                'tipo' => ParametrosTable::TIPO_STRING,
                'descricao' => 'Host de SMTP',
                'nome' => 'SMTP_HOST',
                'valor' => 'smtp.onehost.com.br',
                'obs' => 'Host de SMTP para autenticação'
            ),
            array(
                'tipo' => ParametrosTable::TIPO_STRING,
                'descricao' => 'Usuário de SMTP',
                'nome' => 'SMTP_USER',
                'valor' => 'gerson@onehost.com.br',
                'obs' => 'Usuário de SMTP para autenticação'
            ),
            array(
                'tipo' => ParametrosTable::TIPO_STRING,
                'descricao' => 'Senha de SMTP',
                'nome' => 'SMTP_PASSWORD',
                'valor' => 'gerson',
                'obs' => 'Senha do usuário de SMTP para autenticação'
            )
        ];
        
        $table = $this->table('parametros');
        $table->insert($data)->save();
    }

}
