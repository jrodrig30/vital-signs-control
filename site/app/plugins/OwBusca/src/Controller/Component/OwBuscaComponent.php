<?php

namespace OwBusca\Controller\Component;

use Cake\Controller\Component;
use OwBusca\Lib\Config;
use Cake\Event\Event;
use OwBusca\Lib\OwBuscaTipoBusca;

class OwBuscaComponent extends Component {

    private $Controller;
    private $dadosBusca = [];
    private $dadosLimit = [];

    /**
     * @var \OwBusca\Lib\Config
     */
    private $config;

    /**
     * 
     * @return \OwBusca\Lib\Config
     */
    public function setConfig(array $config) {
        return $this->config = new Config($config);
    }

    public function startup(Event $event) {
        $this->Controller = $event->subject();
        $this->_obterDadosBusca();
        $this->_passarDadosBuscaParaView();
    }

    /**
     * @param array $conditionsDefault
     * @return array
     */
    public function getCondicoes($conditionsDefault = []) {

        if (empty($this->dadosBusca)) {
            return $conditionsDefault;
        }
        
        $this->validarCamposBuscados();

        $condicao = [];
        foreach ($this->dadosBusca as $dadosBusca) {
            $campo = $dadosBusca['campo'];
            $valor = isset($dadosBusca['valor']) ? $dadosBusca['valor'] : '';
            $tipo = isset($dadosBusca['tipo']) ? $dadosBusca['tipo'] : OwBuscaTipoBusca::TIPO_IGUAL_A;
            $entre_min = isset($dadosBusca['entre_min']) ? $dadosBusca['entre_min'] : '';
            $entre_max = isset($dadosBusca['entre_max']) ? $dadosBusca['entre_max'] : '';
            $tipoCampo = $this->_getTipoCampo($campo);

            $isTipoVazio = $tipo == OwBuscaTipoBusca::TIPO_VAZIO;
            $isTipoNaoVazio = $tipo == OwBuscaTipoBusca::TIPO_NAO_VAZIO;
            $isTipoEntre = $tipo == OwBuscaTipoBusca::TIPO_ENTRE;

            if ($isTipoVazio || $isTipoNaoVazio) {
                $valor = 'vazio';
            }

            $valor = $this->_verificarTrim($campo, $valor);

            if (empty($valor) && !strlen($valor) && empty($entre_min) && empty($entre_max)) {
                continue;
            }

            if ($tipoCampo == 'datetime') {
                $campo = 'DATE(' . $campo . ')';
            }

            if (($tipoCampo == 'date' || $tipoCampo == 'datetime')) {
                $valor = $this->_converteFormatoData($valor);
                $entre_min = $this->_converteFormatoData($entre_min);
                $entre_max = $this->_converteFormatoData($entre_max);
            }

            $valor = $this->_getValorConformeTipo($valor, $entre_min, $entre_max, $tipo);

            if (!self::temMultiplosCampos($campo)) {

                if ($isTipoVazio) {
                    $c = $this->_getCampoBuscaConformeTipo($campo, $tipo);
                    $condicao[] = '(' . $c . ' = "" OR ' . $c . ' IS NULL)';
                    continue;
                }

                if ($isTipoNaoVazio) {
                    $condicao[] = $this->_getCampoBuscaConformeTipo($campo, $tipo) . ' ' . $valor;
                    continue;
                }

                if ($isTipoEntre) {
                    $condicao[] = $this->_getCampoBuscaConformeTipo($campo, $tipo) . ' "' . $entre_min . '" AND "' . $entre_max . '"';
                    continue;
                }


                if ($tipoCampo == 'datetime') {
                    $campo = 'DATE(' . $campo . ')';
                }

                if (($tipoCampo == 'date' || $tipoCampo == 'datetime')) {
                    $valor = $this->_converteFormatoData($valor);
                }
                $condicao[$this->_getCampoBuscaConformeTipo($campo, $tipo)] = $valor;
                continue;
            }

            $camposM = explode(' OR ', $campo);
            foreach ($camposM as $campoM) {
                $tipoCampo = $this->_getTipoCampo($campoM);

                if ($tipoCampo == 'datetime') {
                    $campoM = 'DATE(' . $campoM . ')';
                }

                if (($tipoCampo == 'date' || $tipoCampo == 'datetime')) {
                    $valor = $this->_converteFormatoData($valor);
                }

                $condicao['OR'][$this->_getCampoBuscaConformeTipo($campoM, $tipo)] = $valor;
            }
        }

        return $condicao;
    }

    private function _verificarTrim($campo, $valor) {

        if ($this->config->trocarEspacosDuplos()) {
            $valor = preg_replace('/\\s{2,}/', ' ', $valor);
        }

        if ($this->config->trimTodosCampos()) {
            return trim($valor);
        }

        if ($this->config->trimCampo($campo)) {
            return trim($valor);
        }

        return $valor;
    }

    private function _getTipoCampo($campo) {
        $p = explode('.', $campo);
        if (count($p) == 2) {
            $model = $p[0];
            $field = $p[1];
            if ($this->Controller->$model) {
                $t = $this->Controller->$model->schema();
                return $t->column($field)['type'];
            }
        }

        return null;
    }

    private function _converteFormatoData($valor) {
        if (is_array($valor)) {

            if (OwBuscaTipoBusca::isDataBR($valor[0])) {
                $valor[0] = OwBuscaTipoBusca::dataBRToISO($valor[0]);
            }

            if (OwBuscaTipoBusca::isDataBR($valor[1])) {
                $valor[1] = OwBuscaTipoBusca::dataBRToISO($valor[1]);
            }
        } else {
            //remover os % quando adicionados conforme o tipo de busca
            $valor = str_replace('%', '', $valor);
            if (OwBuscaTipoBusca::isDataBR($valor)) {
                $valor = OwBuscaTipoBusca::dataBRToISO($valor);
            }
        }
        return $valor;
    }

    private function _obterDadosBusca() {
        if ($this->efetuouBusca()) {
            $this->dadosBusca = $this->request->query['OwBusca'];
            $this->dadosLimit = isset($this->request->query['OwBuscaLimit']) ? $this->request->query['OwBuscaLimit'] : [];
        }
    }

    private function validarCamposBuscados() {
        foreach ($this->dadosBusca as $valor) {
            if (!$this->config->existeCampo($valor['campo'])) {
                throw new \Exception('Campo inexistente!');
            }
        }
    }

    private static function temMultiplosCampos($campo) {
        return preg_match('/\ OR\ /', $campo);
    }

    private function _passarDadosBuscaParaView() {
        if (!empty($this->dadosBusca)) {
            $this->request->data['OwBusca'] = [];
            $this->Controller->set('OwBuscaViewData', ['OwBusca' => $this->dadosBusca]);
        }

        if (!empty($this->dadosLimit)) {
            $this->request->data['OwBuscaLimit'] = $this->dadosLimit;
        }
    }

    public function beforeRender(Event $event) {
        $this->Controller->helpers['OwBusca.OwBusca'] = ['config' => $this->config];
    }

    public function efetuouBusca() {
        return isset($this->request->query['OwBusca']);
    }

    private function _getValorConformeTipo($valor, $entre_min, $entre_max, $tipo) {
        switch ($tipo) {
            case OwBuscaTipoBusca::TIPO_CONTEM:
                return '%' . $valor . '%';
                break;

            case OwBuscaTipoBusca::TIPO_COMECA_COM:
                return $valor . '%';
                break;

            case OwBuscaTipoBusca::TIPO_TERMINA_COM:
                return '%' . $valor;
                break;

            case OwBuscaTipoBusca::TIPO_VAZIO:
                return 'IS NULL';
                break;

            case OwBuscaTipoBusca::TIPO_NAO_VAZIO:
                return 'IS NOT NULL';
                break;

            case OwBuscaTipoBusca::TIPO_ENTRE:
                return '"' . $entre_min . '" AND "' . $entre_max . '"';
                break;

            default :
                return $valor;
                break;
        }
    }

    private function _getCampoBuscaConformeTipo($campo, $tipo) {

        switch ($tipo) {
            case OwBuscaTipoBusca::TIPO_CONTEM:
            case OwBuscaTipoBusca::TIPO_COMECA_COM:
            case OwBuscaTipoBusca::TIPO_TERMINA_COM:
                return $campo . ' LIKE';
                break;


            case OwBuscaTipoBusca::TIPO_MAIOR_QUE:
                return $campo . ' >';
                break;

            case OwBuscaTipoBusca::TIPO_MENOR_QUE:
                return $campo . ' <';
                break;

            case OwBuscaTipoBusca::TIPO_DIFERENTE_DE:
                return $campo . ' !=';
                break;

            case OwBuscaTipoBusca::TIPO_ENTRE:
                return $campo . ' BETWEEN';
                break;

            default:
                return $campo;
                break;
        }
    }

    public function getLimit($default = 20) {
        return isset($this->dadosLimit['limit']) ? $this->dadosLimit['limit'] : $default;
    }

    public function getURL($urlBase, $conditions = []) {

        $dados = [
            'data' => [
                'OwBusca' => []
            ]
        ];

        foreach ($conditions as $campo => $valor) {
            $dados['data']['OwBusca'][] = [
                'campo' => $campo,
                'valor' => $valor,
                'pass_view' => 1
            ];
        }
        $query = http_build_query($dados);

        if (is_array($urlBase)) {
            $urlBase['?'] = $query;
            return $urlBase;
        }

        $separador = strpos($urlBase, '?') !== false ? '&' : '?';
        return $urlBase . $separador . $query;
    }

    public function adicionarCamposParaTrim($campos) {
        $this->config->addCampoTrim($campos);
    }

    public function getValorCampo($campo, $default = null) {
        foreach ($this->dadosBusca as $dado) {
            if ($dado['campo'] == $campo) {
                if (isset($dado['valor'])) {
                    return $dado['valor'];
                }

                if (isset($dado['entre_min']) && isset($dado['entre_max'])) {
                    return [$dado['entre_min'], $dado['entre_max']];
                }
            }
        }

        return $default;
    }

    public function buscouPorCampo($nomeCampo) {
        foreach ($this->dadosBusca as $dado) {
            if ($dado['campo'] == $nomeCampo) {
                return true;
            }
        }
        return false;
    }

}
