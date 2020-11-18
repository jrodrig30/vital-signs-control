#OwCore

##Como habilitar

**No Controller:**  
  
    public $components = ['OwBusca.OwBusca'];

    public function index(){
        ...
        $this->Paginator->settings = ['conditions' => $this->OwBusca->getCondicoes()];
        ...
    }



**Na View:**  
  
    <?php 
    $opcoes = [
        'campos' => [
            'Cliente.no_Pessoa' => [
                'label' => 'Nome'
            ]
        ],
        'limit' => true, //opcional
        'buscarOnChangeSelect' => true //opcional
    ];
    
    echo $this->OwBusca->mostrarFiltros($opcoes); 
    ?>



##Para usar o Limit, Na view:
    $opcoes['limit'] = true;
no Controller:  
    $this->Paginator->settings['Cliente']['limit'] = $this->OwBusca->getLimit(50);

##Demais opções
###Para setar opções como trim ou remover espaços em branco

No Controller:  
    public $components = ['OwBusca.OwBusca' => options];

Ou criar um arquivo ow_busca.php na pasta Config e adicionar  
  
    $config = [
        'OwBusca' => [
            options
        ]
    ];


Onde `options` pode ser:  
+  **trimTodosCampos**: booleano. Faz trim de todos os campos  
+  **camposTrim**: array. Lista de campos para fazer trim, no formato Model.campo  
+  **trocarEspacosDuplos**: boolean. Substitui 2 ou mais espacos em branco por um só

###Fazer submit ao selecionar um elemento no select das opções
$opcoes['buscarOnChangeSelect'] = true;

### Adicionar algo antes de fechar o form da busca

$opcoes['beforeCloseForm'] = 'html';