<?php
namespace OwIbpt\Lib;

class IbptUtil {
    
    const COLUNA_NCM = 0;
    const COLUNA_PERCENTUAL_NACIONAL = 1;
    const COLUNA_PERCENTUAL_IMPORTADO = 2;
    
    public static function getArquivoTabelaResumida(){
        return realpath(__DIR__ . DS . '..' . DS . 'arquivos' . DS . 'tabela_resumida.csv');
    }
    
    public static function getLinhasTabela(){
        return explode("\n", file_get_contents(self::getArquivoTabelaResumida()));
    }
    
    public static function getArrayDados(){
        $linhas = self::getLinhasTabela();
        $dados = array();
        array_walk($linhas, function ($valor) use(&$dados){
            $dados[] = explode(';', $valor);
        });
        
        return $dados;
    }
    
    public static function getValorImposto($valorProduto, $ncm, $nacional = true, $decimais = 2){
        $percentual = self::getPercentualImposto($ncm, $nacional);
        if($percentual === null){
            return null;
        }
        
        return round($valorProduto * ($percentual / 100), $decimais);
    }
    
    public static function getPercentualImposto($ncm, $nacional = true){
        $percentual = null;
        $f = fopen(self::getArquivoTabelaResumida(), 'r');
        while(false !== ($linha = fgets($f))){
            $campos = explode(';', $linha);
            $vNcm = trim($campos[self::COLUNA_NCM]);
            if($vNcm == $ncm){
                $indice = $nacional ? self::COLUNA_PERCENTUAL_NACIONAL : self::COLUNA_PERCENTUAL_IMPORTADO;
                $percentual = $campos[$indice] * 1.0;
                break;
            }
        }
        fclose($f);
        return $percentual;
    }
}