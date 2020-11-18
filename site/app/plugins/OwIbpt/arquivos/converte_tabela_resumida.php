<?php
namespace arquivos;

$f = fopen('rs.csv', 'r');
//pula primeira linha
fgetcsv($f, 0, ';');
$novoArquivo = '';
while(false !== ($linha = fgetcsv($f, 0, ';'))){
    $totalNacional = $linha[4] * 1.0 + $linha[6] * 1.0 + $linha[7] * 1.0;
    $totalImportado = $linha[5];
    $novoArquivo .= $linha[0] . ';' . $totalNacional . ';' . $totalImportado . "\r\n";
}
fclose($f);

file_put_contents('tabela_resumida.csv', $novoArquivo);