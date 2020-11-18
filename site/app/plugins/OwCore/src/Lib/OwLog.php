<?php
namespace OwCore\Lib;

class OwLog {

    public static function salvarDadosLogEmArquivo($log_dados, $pasta = null) {
        $destino = self::getOrCreatePastaLogs($pasta) . date('d') . '.csv';
        $fp = fopen($destino, 'a');
        fputcsv($fp, $log_dados, chr(9));
        fclose($fp);
    }

    /**
     * Retorna a pasta de destino, sempre anexando o ano e o mês corrente. Da preferencia a configuração de pasta
     * passada como parâmetro no controller, depois pela configuração do OwCore.PastaLogs e por fim é criada uma pasta padrão
     * A configuração de pasta no controller aceita caminho relativo a pasta APP
     * 
     * @param string $pasta
     * @return string
     * @throws Exception
     */
    private static function getOrCreatePastaLogs($pasta = null) {

        if (empty($pasta)) {
            $pasta = Configure::read('OwCore.PastaLogs');
            if (empty($pasta)) {
                $pasta = dirname(dirname(APP)) . DS . 'logs';
            }
        } else {
            $isAbsoluto = substr($pasta, 0, 1) === '/' || preg_match("/^[C-J]\:.+/", $pasta);
            if (!$isAbsoluto) {
                $pasta = APP . $pasta;
            }
        }

        $pasta .= DS . date('Y') . DS . date('m') . DS;

        if (!is_dir($pasta)) {
            if (!mkdir($pasta, 0777, true)) {
                throw new Exception('Não foi possível criar a pasta ' . $pasta);
            }
        }

        return $pasta;
    }

}
