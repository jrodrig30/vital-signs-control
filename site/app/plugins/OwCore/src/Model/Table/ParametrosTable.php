<?php
namespace OwCore\Model\Table;

class ParametrosTable extends AppTable {

    const TIPO_TEXTO_SIMPLES = 1;
    const TIPO_TEXTO_HTML = 2;
    const TIPO_STRING = 3;
    const TIPO_BOOLEANO = 4;
    const TIPO_SELECT = 5;
    const TIPO_INT = 6;
    const TIPO_FLOAT = 7;
    
    public $name = 'Parametro';
    public $validate = array(
        'tipo' => array(
            'rule' => array('numeric')
        ),
        'descricao' => array(
            'rule' => array('notempty')
        ),
        'nome' => array('/.+/'),
        'valor' => array(
            'rule' => array('validarValor'),
            'message' => 'Preencha corretamente o campo abaixo!'
        )
    );
    
    public function validarValor($campo){
        $tipo = $this->data[$this->alias]['tipo'];
        $valor = $this->data[$this->alias]['valor'];
        
        switch ($tipo) {
            case self::TIPO_BOOLEANO:
                return in_array($valor, array('sim', 'nao'), true);
                break;

            case self::TIPO_FLOAT:
                return preg_match('/^[0-9]+(\.[0-9]+)?$/', $valor);
            break;
            
            case self::TIPO_INT:
                return preg_match('/^\-?[0-9]+$/', $valor);
            break;
        }
        
        return true;
    }

    public function getParametros($nome = '') {

        $condicao = "1 = 1";
        if (is_string($nome) && strlen($nome)) {
            $condicao = $this->name . ".nome = '" . $nome . "'";
        }
        if (is_array($nome)) {
            $condicao = $this->name . ".nome in ('" . implode("','", $nome) . "')";
        }

        $d = $this->find('all', array('conditions' => $condicao, 'fields' => array('nome', 'valor')));
        $par = array();
        foreach ($d as $p) {
            $par[$p[$this->name]['nome']] = $p[$this->name]['valor'];
        }

        return $par;
    }

    public function getParametro($nome = '') {
        return $this->getParametros($nome);
    }

    public function getValor() {
        if(func_num_args() < 1){
            throw new Exception('Número de argumentos inválidos!');
        }
        
        $args = func_get_args();
        $nome = $args[0];
        $parametro = Configure::read('ParametrosSistema.' . $nome);
        if($parametro !== null){
            return $parametro;
        }
        
        $v = $this->findByNome($nome);
        if(!empty($v)){
            return $v[$this->alias]['valor'];
        }
        
        if(isset($args[1])){
            return $args[1];
        }
        
        throw new Exception('Parâmetro ' . $nome . ' não encontrado!');
    }

    public static function valor() {
        $p = ClassRegistry::init('OwCore.Parametro');
        return call_user_func_array(array($p, 'getValor'), func_get_args());
    }
    
    public static function v() {
        $p = ClassRegistry::init('OwCore.Parametro');
        return call_user_func_array(array($p, 'getValor'), func_get_args());
    }
    
    public static function salvar($nome, $valor) {
        $p = ClassRegistry::init('Parametro');
        $conditions = array(
            'Parametro.nome' => $nome
        );
        $fields = array('valor' => $valor);
        if($p->updateAll($fields, $conditions) === false) {
            throw new Exception('Não foi possível salvar o parâmetro ' . $nome);
        }
    }
    
    public function afterSave($created, $options = array()) {
        $this->salvarCahce();
        return parent::afterSave($created, $options);
    }
    
    public function salvarCahce(){
        $parametros = $this->find('all');
        $str = "<?php\r\n";
        foreach($parametros as $p){
            
            switch ($p['Parametro']['tipo']) {
                case self::TIPO_BOOLEANO:
                    $valor = $p['Parametro']['valor'] == 'sim' ? 'true' : 'false';
                break;
                case self::TIPO_INT:
                    $valor = (int)$p['Parametro']['valor'];
                break;
                case self::TIPO_FLOAT:
                    $valor = number_format($p['Parametro']['valor'], 2, ".", "");
                break;
                default:
                    $valor = "'" . addslashes($p['Parametro']['valor']) . "'";
                    break;
            }
            $str .= "Configure::write('ParametrosSistema.". $p['Parametro']['nome'] ."', ". $valor .");\r\n";
        }
        
        $str .= "?>";
        
        $arquivo = TMP . 'parametros_cache.php';
        if(!file_put_contents($arquivo, $str)){
            throw new Exception('Não foi possível salvar o cache de parâmetros em ' . $arquivo);
        }
    }
    
    public static function getTipos(){
        return array(
            self::TIPO_TEXTO_SIMPLES => 'Texto Simples',
            self::TIPO_TEXTO_HTML => 'Texto HTML',
            self::TIPO_STRING => 'String',
            self::TIPO_BOOLEANO => 'Boolean',
            self::TIPO_SELECT => 'Select',
            self::TIPO_INT => 'Inteiro',
            self::TIPO_FLOAT => 'Decimal',
        );
    }
    
    public static function getNomeTipo($tipo){
        $tipos = self::getTipos();
        return $tipos[$tipo];
    }

}

?>