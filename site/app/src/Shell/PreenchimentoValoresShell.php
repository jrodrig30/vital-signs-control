<?php

namespace App\Shell;

use Cake\Console\Shell;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;

/**
 * 
 */
class PreenchimentoValoresShell extends Shell {

    public function initialize() {
        $this->conn_default = ConnectionManager::get('default');
    }

    public function main() {
        //Paciente Id, Idade, Genero, Frequencia Cardiaca, Data e hora da coleta
        //$this->migrateInitialData();
        $this->preencherValoresVazios();
    }

    private function preencherValoresVazios() {
        $numberOfLines = 1000;
        $numbersLinesSkip = 0;
        $valoresNulo = 0;
        while (TRUE) {
            $sql = "SELECT SV.paciente
               FROM sinais_vitais SV
               WHERE SV.temperatura is null
               group by SV.paciente
               OFFSET " . $numbersLinesSkip . " LIMIT " . $numberOfLines . " 
               ;";

            $dadosPsql = $this->conn_default->execute($sql)->fetchAll('assoc');
            if (empty($dadosPsql)) {
                break;
            }

            $this->out('Primeiro Passo');
            foreach ($dadosPsql as $dado) {
                $sql = "select SV.id, SV.idade, SV.paciente, SV.temperatura, (
                        select SV2.temperatura from sinais_vitais SV2
                        where ( SV2.id > SV.id)
                        and SV.paciente = SV2.paciente
                        and SV2.temperatura is not null
                        order by SV2.id
                        limit 1
                    ) as valor_anterior from sinais_vitais SV
                    where SV.paciente=" . $dado['paciente'] . "
                    and SV.temperatura is null;";

                $dados = $this->conn_default->execute($sql)->fetchAll('assoc');
                foreach ($dados as $valor) {
                                        

                    if (empty($valor['valor_anterior'])) {
                        $valoresNulo++;
                        $this->out('Quantidade de valores nulos é de ' . $valoresNulo);
                        $valor['valor_anterior'] = 37;
                    }
                    

                    $sinaisVitaisTable = TableRegistry::get('SinaisVitais');
                    $sinal = $sinaisVitaisTable->get($valor['id']); // Return article with id 12
                    $sinal->temperatura = $valor['valor_anterior'];
                    $sinaisVitaisTable->save($sinal);
                    $this->out($valor['id']);
                    $this->out('Atualizou o paciente ' . $valor['paciente']);
                }
            }

            $numbersLinesSkip = $numbersLinesSkip + 1000;
            $this->out($numbersLinesSkip);
        }

        $this->out('fim');
    }

}
