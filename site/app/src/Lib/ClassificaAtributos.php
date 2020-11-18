<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Lib;

use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Core\Exception\Exception;

/**
 * Description of ClassificaAtributos
 *
 * @author jose
 */
class ClassificaAtributos {

    public function start() {
        $python_path = dirname(dirname(dirname(APP))) . DS . 'public_html' . DS . 'python' . DS;
        $site = dirname(APP);
        $command = '/usr/bin/php ' . $site . DS . 'bin' . DS . 'cake.php Classificador >> /dev/null 2>&1 & echo $!;';
        $pid = exec($command, $r);
        while (file_exists("/proc/{$pid}")) {
            echo '';
        }

        
        $pid_rm = exec('rm -f '. $python_path . "data-set-sinais-vitais.csv >> /dev/null 2>&1 & echo $!;");
        while (file_exists("/proc/{$pid_rm}")) {
            echo '';
        }
        
        $pid_mv = exec('mv -f ' . TMP . DS . 'data-set-sinais-vitais.csv ' . $python_path . " >> /dev/null 2>&1 & echo $!;");
        while (file_exists("/proc/{$pid_mv}")) {
            echo '';
        }


        $pid_mv2 = exec('mv ' . $python_path . 'decision_tree.pk1 ' . $python_path . date('Ymds') . '.pk1  >> /dev/null 2>&1 & echo $!;');
        while (file_exists("/proc/{$pid_mv2}")) {
            echo '';
        }

        $pid_python = exec('python3 ' . $python_path . 'gera_classificador.py  >> /dev/null 2>&1 & echo $!;');
        while (file_exists("/proc/{$pid_python}")) {
            echo '';
        }
    }

    public function atualizarScript($dados) {
        $Parametros = TableRegistry::get('Parametros');
        $query = $Parametros->find('all')->where(['Parametros.nome' => 'ULTIMA_LINHA']);
        $parametro = $query->toArray();
        $file = dirname(__DIR__) . DS . 'Shell' . DS . 'ClassificadorShell.php';
        $content = file($file); //Read the file into an array. Line number => line content
        foreach ($content as $lineNumber => &$lineContent) { //Loop through the array (the "lines")
            if ($lineNumber == $parametro[0]->valor) { //Remember we start at line 0.
                $lineContent .= "if(";
                $classe = '';
                $cont = 0;
                foreach ($dados['diagnosticos_sinais'] as $dado) {
                    if ($cont > 0) {
                        $lineContent .= ' && ';
                    }

                    if (!empty($dado['idade_maxima'])) {
                        $lineContent .= "( (\$idade <= " . $dado['idade_maxima'];
                        $lineContent .= " && \$idade >= " . $dado['idade_minima'] . ") && ";
                    }

                    if ($dado['sinal_id'] == 1) {
                        $lineContent .= "\$frequencia_cardiaca ";
                    }


                    if ($dado['sinal_id'] == 2) {
                        $lineContent .= "\$frequencia_respiratoria ";
                    }

                    if ($dado['sinal_id'] == 3) {
                        $lineContent .= "\$pressao_dia ";
                    }

                    if ($dado['sinal_id'] == 4) {
                        $lineContent .= "\$pressao_sis ";
                    }

                    if ($dado['sinal_id'] == 5) {
                        $lineContent .= "\$pam ";
                    }

                    if ($dado['sinal_id'] == 6) {
                        $lineContent .= "\$saturacao_oxigenio ";
                    }

                    if ($dado['sinal_id'] == 7) {
                        $lineContent .= "\$temperatura ";
                    }

                    if (!empty($dado['valor_maximo'])) {
                        $lineContent .= ' > ' . $dado['valor_maximo'] . " ";
                    }

                    if (!empty($dado['valor_minimo'])) {
                        $lineContent .= ' < ' . $dado['valor_minimo'] . " ";
                    }

                    if (!empty($dado['valor_medio'])) {
                        $lineContent .= ' != ' . $dado['valor_medio'] . " ";
                    }

                    if (!empty($dado['idade_maxima'])) {
                        $lineContent .= ") ";
                    }

                    $cont++;
                }


                $lineContent .= "){";
                $lineContent .= "\$classe.='" . $dados['codigo'] . "';";
                $lineContent .= "}";
                $lineContent .= PHP_EOL;
            }
        }

        $parametro_valor = $Parametros->get(1); // Return article with id 12
        $parametro_valor->valor = $parametro[0]->valor + 1;
        if ($Parametros->save($parametro_valor) === false) {
            throw new Exception('Não foi possível salvar o parâmetro!');
        }

        $allContent = implode("", $content); //Put the array back into one string
        file_put_contents($file, $allContent);
    }

    public function removerLinhaScript($linha) {
        $file = dirname(__DIR__) . DS . 'Shell' . DS . 'ClassificadorShell.php';
        $content = file($file); //Read the file into an array. Line number => line content
        foreach ($content as $lineNumber => &$lineContent) { //Loop through the array (the "lines")
            if ($lineNumber == $linha) { //Remember we start at line 0.
                $lineContent = "";
            }
        }

        $allContent = implode("", $content); //Put the array back into one string
        file_put_contents($file, $allContent);

        $Diagnosticos = TableRegistry::get('Diagnosticos');
        $query = $Diagnosticos->find('all')->where(['Diagnosticos.linha >' => $linha]);
        $diagnosticos = $query->toArray();

        foreach ($diagnosticos as $diagnostico) {
            $dado = $Diagnosticos->get($diagnostico->id); // Return article with id 12
            $dado->linha = $diagnostico->linha - 1;
            if ($Diagnosticos->save($dado) === false) {
                throw new Exception('Não foi possível remover a linha do script!');
            }
        }

        $Parametros = TableRegistry::get('Parametros');
        $parametro_valor = $Parametros->get(1); // Return article with id 12
        $parametro_valor->valor = $parametro_valor->valor - 1;
        if ($Parametros->save($parametro_valor) === false) {
            throw new Exception('Não foi possível salvar o parâmetro!');
        }

        return TRUE;
    }

}
