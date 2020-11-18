<?php
namespace OwIbpt\Console\Command;

use Cake\Console\Shell;

class IbptShell extends Shell {

    public $uses = array('Produto');

    public function main() {
        $c_ex_tipi = isset($this->params['c_ex_tipi']) ? $this->params['c_ex_tipi'] : 'ex_tipi';
        
        if(!file_exists(TMP . 'ibpt.csv')){
            $this->out('Criar o arquivo ' . TMP . 'ibpt.csv');
            exit(1);
        }
        
        $f = fopen(TMP . 'ibpt.csv', 'r');
        $linhasAlteradas = 0;
        while(false !==($linha = fgetcsv($f, 0, ';'))){
            $ncm = trim($linha[0]);
            $ex_tipi = trim($linha[1]);
            $alNacional = trim($linha[4]);
            $sql = "UPDATE produtos SET percentual_medio_imposto = '". $alNacional ."' WHERE ncm = '". $ncm ."'";
            if(strlen($ex_tipi)){
                $sql .= " AND " . $c_ex_tipi . " = '". $ex_tipi ."'";
            }else{
                $sql .= " AND (" . $c_ex_tipi . " IS NULL OR ". $c_ex_tipi ." = '')";
            }
            
            $this->Produto->query($sql);
            $linhasAlteradas += $this->Produto->getAffectedRows();
        }
        fclose($f);
        
        $this->out('Linhas afetadas: ' . $linhasAlteradas);
    }
}