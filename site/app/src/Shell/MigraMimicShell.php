<?php

namespace App\Shell;

use Cake\Console\Shell;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;

/**
 * 
 */
class MigraMimicShell extends Shell {

    private $conn_default;
    private $conn_physionet;

    public function initialize() {
        $this->conn_default = ConnectionManager::get('default');
        $this->conn_physionet = ConnectionManager::get('physionet');
    }

    public function main() {
        //Paciente Id, Idade, Genero, Frequencia Cardiaca, Data e hora da coleta
        //$this->migrateInitialData();
        $this->migrateBreathRate();
    }

    //Paciente Id, Idade, Genero, Frequencia Cardiaca, Data e hora da coleta
    public function migrateInitialData() {
        $numberOfLines = 1000;
        $numbersLinesSkip = 0;

        while (TRUE) {
            $sql = "SELECT C1.subject_id as paciente,
               C1.value as frequencia_cardiaca,
               C1.charttime as horario,
               date_part('year',age(C1.charttime, P.dob)) as idade,
               P.gender
               FROM chartevents C1, patients P
               WHERE C1.value is not null 
                AND C1.value != '0'
                AND C1.itemid = 211 
                AND P.subject_id = C1.subject_id
                OFFSET " . $numbersLinesSkip . " LIMIT " . $numberOfLines . ";";

            $dadosPsql = $this->conn_default->execute($sql)->fetchAll('assoc');
            if (empty($dadosPsql)) {
                break;
            }

            $sinais = TableRegistry::get('SinaisVitais');
            $entities = $sinais->newEntities($dadosPsql);
            $result = $sinais->saveMany($entities);
            if ($result == false) {
                $this->out('Não foi possível migrar os dados!');
            }

            $numbersLinesSkip = $numbersLinesSkip + 1000;
            $this->out($numbersLinesSkip);
        }

        $this->out('Fim');
    }

    public function migrateBreathRate() {
        $numberOfLines = 1000;
        $numbersLinesSkip = 0;

        while (TRUE) {
            $sql = "SELECT C1.subject_id as paciente,
               C1.value as frequencia_respiratoria,
               C1.charttime as horario,
               date_part('year',age(C1.charttime, P.dob)) as idade,
               P.gender
               FROM chartevents C1, patients P
               WHERE C1.value is not null 
                AND C1.value != '0'
                AND C1.itemid = 618 
                AND P.subject_id = C1.subject_id
                OFFSET " . $numbersLinesSkip . " LIMIT " . $numberOfLines . ";";

            $dadosPsql = $this->conn_default->execute($sql)->fetchAll('assoc');
            if (empty($dadosPsql)) {
                break;
            }

            foreach ($dadosPsql as $dado) {
                $sinais = TableRegistry::get('SinaisVitais');
                $leitura = $sinais->find()
                        ->select(['id', 'frequencia_respiratoria'])
                        ->where(['paciente' => $dado['paciente'], 'horario' => $dado['horario']])
                        ->first();

                if (!empty($leitura) && empty($leitura->frequencia_respiratoria)) {
                    $leitura->frequencia_respiratoria = $dado['frequencia_respiratoria'];
                    if ($sinais->save($leitura)) {
                        $this->out('Editou: ' . $leitura->id);
                    }
                }

                if (empty($leitura)) {
                    $sinal = $sinais->newEntity();

                    $sinal->paciente = $dado['paciente'];
                    $sinal->idade = $dado['idade'];
                    $sinal->horario = $dado['horario'];
                    $sinal->frequencia_respiratoria = $dado['frequencia_respiratoria'];
                    $sinal->gender = $dado['gender'];

                    if ($sinais->save($sinal)) {
                        $this->out('Adicionou: ' . $sinal->id);
                    }
                }
            }

            $numbersLinesSkip = $numbersLinesSkip + 1000;
            $this->out('Registros Skip: ' . $numbersLinesSkip);
        }

        $this->out('Fim');
    }

}
