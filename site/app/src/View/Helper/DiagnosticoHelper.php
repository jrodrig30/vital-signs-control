<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\View\Helper;

use Cake\View\Helper;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;

/**
 * Description of DiagnosticoHelper
 *
 * @author jose
 */
class DiagnosticoHelper extends Helper {

    const NORMAL = 99;
    const TAQUICARDIA = 31;
    const BRADICARDIA = 32;
    const HIPERTERMIA = 33;
    const HIPOTERMIA = 34;
    const BRADIPNEIA = 35;
    const TAQUIPNEIA = 36;
    const INFARTO_AGUDO_MIOCARDIO = 37;
    const CHOQUE_ANAFILATICO = 38;
    const INSUFICIENCIA_RESPIRATORIA = 39;
    const EDEMA_PULMONAR = 10;
    const INSUFICIENCIA_DIGESTIVA_CARDIACA = 11;
    const DPOC = 12;
    const PICO_HIPERTENSIVO = 13;
    const APNEIA = 14;
    const SEPSE = 15;
    const HEMORRAGIA = 16;
    const FEBRE = 17;
    const PRESSAO_SIS_ALTA = 18;
    const PRESSAO_SIS_BAIXA = 19;
    const PRESSAO_DIA_ALTA = 20;
    const PRESSAO_DIA_BAIXA = 21;

    public function initialize(array $config) {
        
    }

    public function getDiagnostico($idade, $frequencia_cardiaca, $frequencia_respiratoria, $pressao_dia, $pressao_sis, $pam, $sataturacao, $temperatura) {
        $curl = curl_init();
// Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'http://localhost:5000/get_diagnostico?idade=' . $idade
            . '&frequencia_cardiaca=' . $frequencia_cardiaca . '&frequencia_respiratoria='
            . $frequencia_respiratoria . '&pressao_dia=' . $pressao_dia . '&pressao_sis=' . $pressao_sis
            . '&pam=' . $pam . '&saturacao=' . $sataturacao . '&temperatura=' . $temperatura,
            CURLOPT_USERAGENT => 'Codular Sample cURL Request'
        ));
// Send the request & save response to $resp
        $resp = curl_exec($curl);
// Close request to clear up some resources
        curl_close($curl);
        $resp_php = json_decode($resp);
        if (!$resp_php) {
            return '';
        }

        return $resp_php->prediction;
    }

    public static function getDiagnosticos() {
        return [
            self::NORMAL => 'Normal',
            self::TAQUICARDIA => 'Taquicardia',
            self::BRADICARDIA => 'Bradicardia',
            self::HIPERTERMIA => 'Hipertermia',
            self::HIPOTERMIA => 'Hipotemia',
            self::BRADIPNEIA => 'Bradpineia',
            self::TAQUIPNEIA => 'Taquipneia',
            self::INFARTO_AGUDO_MIOCARDIO => 'Infarto Agudo do Miocardio',
            self::CHOQUE_ANAFILATICO => 'Choque Anafilático',
            self::INSUFICIENCIA_RESPIRATORIA => 'Insuficiência Respiratória',
            self::EDEMA_PULMONAR => 'Edema Pulmonar',
            self::INSUFICIENCIA_DIGESTIVA_CARDIACA => 'Insuficiência Digestiva Cardíaca',
            self::DPOC => 'DPOC',
            self::PICO_HIPERTENSIVO => 'Pico Hipertensivo',
            self::APNEIA => 'Apnéia',
            self::SEPSE => 'Sepse',
            self::HEMORRAGIA => 'Hemorragia',
            self::FEBRE => 'Febre',
            self::PRESSAO_SIS_ALTA => 'Pressão Sistólica Alta',
            self::PRESSAO_SIS_BAIXA => 'Pressão Sistólica Baixa',
            self::PRESSAO_DIA_ALTA => 'Pressão Diastólica Alta',
            self::PRESSAO_DIA_BAIXA => 'Pressão Diastólica Baixa',
        ];
    }

    public function getNomeDiagnostico($codigo, $detalhar = false) {
        if ($codigo == self::NORMAL) {
            return 'Normal';
        }

        if ($detalhar) {
            if (strlen($codigo) > 1) {
                $codigos = $this->getArrayDiagnostico($codigo);
                $nomes = '';
                foreach ($codigos as $diagnostico) {
                    $nomes .= $this->getNome($diagnostico);
                    $Diagnosticos = TableRegistry::get('Diagnosticos');
                    $dados = $Diagnosticos->find('all')->where(['Diagnosticos.codigo' => $diagnostico]);
                    $dados = $dados->toArray();
                    $nomes .= ' => Sinais: ' . $this->getSinaisByDiagnostico($dados[0]->id) . ' ' . PHP_EOL;
                }

                return $nomes;
            }

            return $this->getNome($codigo);
        }

        if (strlen($codigo) > 1) {
            $codigos = $this->getArrayDiagnostico($codigo);
            $nomes = '';
            foreach ($codigos as $diagnostico) {
                $nomes .= $this->getNome($diagnostico) . ', ';
            }

            return rtrim($nomes, ', ');
        }

        return $this->getNome($codigo);
    }

    private function getNome($codigo) {
        if ($codigo == self::NORMAL) {
            return 'Normal';
        }

        $Diagnosticos = TableRegistry::get('Diagnosticos');
        $dados = $Diagnosticos->find('all')->where(['Diagnosticos.codigo' => $codigo]);
        $dados = $dados->toArray();
        if (!isset($dados[0])) {
            return 'Não encontrada';
        }

        return $dados[0]->nome;
    }

     private function getNomeAcao($codigo) {
        $Diagnosticos = TableRegistry::get('Diagnosticos');
        $dados = $Diagnosticos->find('all')->where(['Diagnosticos.codigo' => $codigo]);
        $dados = $dados->toArray();
        if (!isset($dados[0])) {
            return 'Não encontrada';
        }

        return $dados[0]->acao;
    }

    public function sinalIsResponsavel($codigo, $sinal_id) {
        if ($codigo == self::NORMAL) {
            return '';
        }

        $array_diagnostico = $this->getArrayDiagnostico($codigo);
        foreach ($array_diagnostico as $dianostico) {
            $Diagnosticos = TableRegistry::get('Diagnosticos');
            $dados = $Diagnosticos->find('all')->where(['Diagnosticos.codigo' => $dianostico])->contain(['DiagnosticosSinais']);
            $dados = $dados->toArray();
            if (!isset($dados[0])) {
                return '';
            }

            foreach ($dados[0]['diagnosticos_sinais'] as $dado) {
                if ($dado->sinal_id == $sinal_id) {
                    return 'sinal_responsavel';
                }
            }
        }
    }

    private function getArrayDiagnostico($diagnostico) {
        $array = [];
        for ($cont = 0; $cont < strlen($diagnostico); $cont++) {
            $array[] = substr($diagnostico, $cont, 1);
        }

        return $array;
    }

     public function getAcao($codigo) {
        $codigos = $this->getArrayDiagnostico($codigo);
            $nomes = '';
            foreach ($codigos as $diagnostico) {
                $nomes .= $this->getNomeAcao($diagnostico) . ', ';
            }

            return rtrim($nomes, ', ');
    }

    public function getSinaisByDiagnostico($diagnosticoId) {
        $DiagnosticosSinais = TableRegistry::get('DiagnosticosSinais');
        $dados = $DiagnosticosSinais->find('all')->where(['DiagnosticosSinais.diagnostico_id' => $diagnosticoId]);
        $dados = $dados->toArray();
         $nomes = '';
        foreach ($dados as $dado) {

            $Sinais = TableRegistry::get('Sinais');
            $sinais = $Sinais->find('all')->where(['Sinais.id IN' => $dado->sinal_id]);
           
            foreach ($sinais->toArray() as $sinal) {
                $nomes .= $sinal->nome . ' ';
                if (!empty($dado->valor_maximo)) {
                    $nomes .= ' > ' . $dado->valor_maximo . ', ';
                }

                if (!empty($dado->valor_minimo)) {
                    $nomes .= ' < ' . $dado->valor_minimo . ', ';
                }

                if (!empty($dado->valor_medio)) {
                    $nomes .= ' <b> <> </b> ' . $dado->valor_medio . ', ';
                }
            }
        }



        return rtrim($nomes, ", ");
    }

}
