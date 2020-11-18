<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Shell;

use Cake\Console\Shell;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;

/**
 * Description of Classificador
 *
 * @author jose
 */
class ClassificadorShell extends Shell {

    const NORMAL = '30';
    const TAQUICARDIA = '31';
    const BRADICARDIA = '32';
    const HIPERTERMIA = '33';
    const HIPOTERMIA = '34';
    const BRADIPNEIA = '35';
    const TAQUIPNEIA = '36';
    const INFARTO_AGUDO_MIOCARDIO = '37';
    const CHOQUE_ANAFILATICO = '38';
    const INSUFICIENCIA_RESPIRATORIA = '39';
    const EDEMA_PULMONAR = '40';
    const INSUFICIENCIA_DIGESTIVA_CARDIACA = '11';
    const DPOC = '12';
    const PICO_HIPERTENSIVO = '13';
    const APNÉIA = '14';
    const SEPSE = '15';
    const HEMORRAGIA = '16';
    const FEBRE = '17';
    const PRESSAO_SIS_ALTA = '18';
    const PRESSAO_SIS_BAIXA = '19';
    const PRESSAO_DIA_ALTA = '20';
    const PRESSAO_DIA_BAIXA = '21';
    const PRESSA0_DIA_0A5ANOS = 60;
    const PRESSA0_DIA_6A9ANOS = 62;
    const PRESSA0_DIA_10A11ANOS = 65;
    const PRESSA0_DIA_12A15ANOS = 67;
    const PRESSA0_DIA_16A18ANOS = 75;
    const PRESSA0_DIA_19A59ANOS = 80;
    const PRESSA0_DIA_MAIS60ANOS = 100;
    const PRESSA0_SIS_0A5ANOS = 85;
    const PRESSA0_SIS_6A9ANOS = 95;
    const PRESSA0_SIS_10A11ANOS = 100;
    const PRESSA0_SIS_12A15ANOS = 108;
    const PRESSA0_SIS_16A18ANOS = 118;
    const PRESSA0_SIS_19A59ANOS = 120;
    const PRESSA0_SIS_MAIS60ANOS = 160;
    const MAX_FREQ_CARD = 100;
    const MIN_FREQ_CARD = 60;
    const MAX_TEMP = 40;
    const MIN_TEMP = 35;
    const TEMP_MAX_NORMAL = 37.5;
    const MIN_FREQ_RESP_ATE12MESES = 30;
    const MIN_FREQ_RESP_1_A_5ANOS = 20;
    const MIN_FREQ_RESP_6_A_12ANOS = 12;
    const MIN_FREQ_RESP_MAIOR12ANOS = 10;
    const MAX_FREQ_RESP_ATE1ANO = 50;
    const MAX_FREQ_RESP_1_A_5ANOS = 40;
    const MAX_FREQ_RESP_MAIOR5ANOS = 30;
    const MAX_PAM = 130;
    const MIN_PAM = 60;
    const MIN_SO2 = 90;

    public function main() {
        $file = fopen(TMP . 'data-set-sinais-vitais.csv', 'w');
        fputcsv($file, array('idade', 'frequencia_cardiaca', 'frequencia_respiratoria', 'pressao_dia', 'pressao_sis', 'pressao_media', 'saturacao_oxigenio', 'temperatura', 'classe'));
        $classes_novas = [];
        $fc = fopen(TMP . 'sinais_vitais.csv', 'r');
        while (($campos = fgetcsv($fc, 0, ',')) !== false) {
            if (!is_numeric($campos[0])) {
                continue;
            }

            $idade = $campos[0];
            $frequencia_cardiaca = $campos[1];
            $frequencia_respiratoria = $campos[2];
            $pressao_dia = $campos[3];
            $pressao_sis = $campos[4];
            $saturacao_oxigenio = $campos[5];
            $temperatura = $campos[6];
            $pam = ((($pressao_dia * 2) + $pressao_sis) / 3);
            $classe = $this->getClasse($idade, $frequencia_cardiaca, $frequencia_respiratoria, $pressao_sis, $pressao_dia, $pam, $saturacao_oxigenio, $temperatura);
            $classe = empty($classe) ? '99' : $classe;
            $row = [
                intval($idade),
                intval($frequencia_cardiaca),
                intval($frequencia_respiratoria),
                intval($pressao_dia),
                intval($pressao_sis),
                floatval($pam),
                intval($saturacao_oxigenio),
                floatval($temperatura),
                $classe
            ];

            fputcsv($file, $row);
        }

        fclose($file);
    }

    private function getClasse($idade, $frequencia_cardiaca, $frequencia_respiratoria, $pressao_sis, $pressao_dia, $pam, $saturacao_oxigenio, $temperatura) {
        $classe = '';
if($frequencia_cardiaca  > 100 ){$classe.='A';}
if($frequencia_cardiaca  < 60 ){$classe.='B';}
if($temperatura  > 38 ){$classe.='C';}
if($temperatura  < 35 ){$classe.='D';}
if($frequencia_respiratoria  < 10 ){$classe.='E';}
if($frequencia_respiratoria  > 21 ){$classe.='F';}
if($frequencia_cardiaca  > 100  && $pam  > 110 ){$classe.='G';}
if($frequencia_cardiaca  < 60  && $pam  < 70 ){$classe.='H';}
if($frequencia_cardiaca  < 60  && $saturacao_oxigenio  < 90 ){$classe.='I';}
if($frequencia_cardiaca  > 100  && $saturacao_oxigenio  < 90 ){$classe.='J';}
if($saturacao_oxigenio  < 90  && $pam  < 70 ){$classe.='L';}
if($frequencia_respiratoria  > 21  && $pam  > 110 ){$classe.='M';}
if($frequencia_respiratoria  < 10  && $saturacao_oxigenio  < 90 ){$classe.='N';}
if($temperatura  > 38  && $saturacao_oxigenio  < 90 ){$classe.='O';}
if($pam  < 70 ){$classe.='P';}
if($pam  > 110 ){$classe.='Q';}
       
        
        
        return $classe;
    }

}
