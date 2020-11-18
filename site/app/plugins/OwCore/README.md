Adicionar no controller:

public $components = array('RequestHandler','OwCore.Main');

Para liberar alguma url no controller: $this->Main->allow($url); 

Para criar as tabelas do OwCore:
1º Via DOS acesse o local onde está armazenado o site:
Exemplo : cd c:\site\meusite

2º Digite o seguinte comando:
./bin/cake migrations migrate -p OwCore
ou
php /bin/cake.php migrations migrate -p OwCore
Obs: É necessario primeiramente criar o Banco de dados do "meusite"

Para popular as tabelas associadas ao plugin OwCore com os dados padrões execute:
./bin/cake migrations seed -p OwCore
ou
php /bin/cake.php migrations eed -p OwCore


O usuário padrão é suporte@onehost.com.br e a senha no arquivp /OwCore/config/Seeds/UsuarioSeed.php


Para Configurar pasta padrão para logs:
app/Conf/bootstrap.php:
Configure::write('PastaLogs','/public_html/logs');

app/Conf/ow_core.php:
$config = array(
    'OwCore' => [
        'PastaLogs' => '/public_html/logs'
    ]
);

Para as configurações acima o arquivo de logs será salvo em: public_html/logs/ano/mes/LogDia10.csv (Exemplo)

Ou configurar no controller, exemplo:
$components = ['OwCore.Log' => ['pasta' => '../../arquivos/logs']];
A pasta quando relativa, será relativa a pasta APP.

Pode-se usar eventos para processar o log, os eventod disponíveis são:
OwCore.Component.Log.beforeSetDadosLog
OwCore.Component.Log.afterSetDadosLog

Ambos tem como parâmetro em data o campo 'dados' que pode ser processado e retornado pelo evento.
É útil em casos onde deve-se personalizar algum dado.