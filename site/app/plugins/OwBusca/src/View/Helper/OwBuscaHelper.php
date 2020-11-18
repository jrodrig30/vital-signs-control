<?php
namespace OwBusca\View\Helper;

use OwBusca\Lib\OwBuscaTipoBusca;
use OwBusca\Controller\Component\OwBuscaComponent;
use Cake\View\Helper;

class OwBuscaHelper extends Helper {

    public $helpers = array('Session', 'Form', 'Html', 'Paginator');
    private $config;
    
    public function initialize(array $config) {
        $this->config = $config['config'];
        return parent::initialize($config);
    }
    public function mostrarFiltros() {
        $opcoes = $this->config->getConfig();
        
        $this->_adicionarScripts();

        $campos = $opcoes['campos'];

        //remove a pagina
        $action = preg_replace('/\/page:[0-9]+(\/)?/', '', $this->request->here);
        if (isset($opcoes['action'])) {
            $action = $opcoes['action'];
        }

        $html = '<div class="OwCamposBusca" id="OwCamposBusca">';
        $html .= '<h4>Busca</h4>';
        $html .= '<form action="' . $action . '">';
        $count = 0;
        foreach ($campos as $k => $campo) {

            $campoBusca = is_string($campo) ? $campo : $k;
            $label = is_array($campo) && isset($campo['label']) ? $campo['label'] : $campo;
            $tipo = $this->Form->value('OwBusca.' . $count . '.tipo');
            $displayEntre = $tipo == OwBuscaTipoBusca::TIPO_ENTRE ? 'block' : 'none';
            $hideCampo = $tipo == OwBuscaTipoBusca::TIPO_ENTRE || $tipo == OwBuscaTipoBusca::TIPO_VAZIO || $tipo == OwBuscaTipoBusca::TIPO_NAO_VAZIO;
            $displayCampo = $hideCampo ? 'none' : 'block';
            $colunas = isset($campo['colunas']) ? $campo['colunas'] : false;

            $defaultIgualA = isset($campo['options_valor']['options']);

            $optionsTipo = array(
                'class' => 'OwBuscaCampoTipo',
                'options' => OwBuscaTipoBusca::tipoBuscas(),
                'default' => $defaultIgualA ? OwBuscaTipoBusca::TIPO_IGUAL_A : '',
                'type' => 'select',
                'label' => $label,
                'value' => $this->getValorCampo($k, 'tipo')
            );

            $optionsValor = array(
                'label' => false,
                'div' => false,
                'style' => 'display: ' . $displayCampo,
                'value' => $this->getValorCampo($k, 'valor')
            );

            $optionsValorMin = array(
                'label' => false,
                'div' => false,
                'class' => 'min min_' . $count,
                'style' => 'display: ' . $displayEntre . ';',
                'value' => $this->getValorCampo($k, 'entre_min')
            );

            $optionsValorMax = array(
                'label' => false,
                'div' => false,
                'class' => 'max max_' . $count,
                'style' => 'display: ' . $displayEntre . ';',
                'value' => $this->getValorCampo($k, 'entre_max')
            );


            if (is_array($campo) && isset($campo['options_valor'])) {
                $optionsValor = array_merge_recursive($optionsValor, $campo['options_valor']);
            }

            if (is_array($campo) && isset($campo['options_tipo'])) {
                $optionsTipo = array_merge_recursive($optionsTipo, $campo['options_tipo']);
                
                if(isset($campo['options_tipo']['options'])){
                    $optionsTipo['options'] = $campo['options_tipo']['options'];
                }
                
                if (isset($campo['options_tipo']['default'])) {
                    $optionsTipo['default'] = $campo['options_tipo']['default'];
                }
            }

            if (is_array($campo) && isset($campo['options_max'])) {
                $optionsValorMax = array_merge_recursive($optionsValorMax, $campo['options_max']);
            }

            if (is_array($campo) && isset($campo['options_min'])) {
                $optionsValorMin = array_merge_recursive($optionsValorMin, $campo['options_min']);
            }

            $this->_setarValorCampo($optionsValor);
            $this->_setarValorCampo($optionsTipo);
            $this->_setarValorCampo($optionsValorMax);
            $this->_setarValorCampo($optionsValorMin);

            $html .= '<div class="OwBuscaCampoBusca" id="DivOwBuscaCampoBusca' . $count . '">';
            if ($colunas) {
                $html .= $this->Form->input('OwBusca.' . $count . '.campo', array('class' => 'ow_campos', 'options' => $colunas, 'div' => array('class' => 'OwBuscaCampos'), 'label' => false));
                $optionsTipo['label'] = false;
            } else {
                $html .= $this->Form->input('OwBusca.' . $count . '.campo', array('type' => 'hidden', 'value' => $campoBusca));
            }

            $html .= $this->Form->input('OwBusca.' . $count . '.tipo', $optionsTipo);
            $html .= '<div class="DivOwBuscaValor">';
            $html .= $this->Form->input('OwBusca.' . $count . '.valor', $optionsValor);
            $html .= $this->Form->input('OwBusca.' . $count . '.entre_min', $optionsValorMin);
            $html .= $this->Form->input('OwBusca.' . $count . '.entre_max', $optionsValorMax);
            $html .= '</div>';
            $html .= '<div class="clear"></div>';
            $html .= '</div>';
            $html .= '<div class="clear"></div>';
            $count++;
        }
        if (isset($opcoes['limit']) && $opcoes['limit']) {
            $limit_options = isset($opcoes['limit_options']) ? $opcoes['limit_options'] : array();
            $html .= $this->getSelectLimit($limit_options);
        }

        if (isset($opcoes['buscarOnChangeSelect']) && $opcoes['buscarOnChangeSelect']) {
            $html .= '<input type="hidden" id="OwBuscaBuscarOnChangeSelect" value="1" />';
        }

        $html .= $this->Form->submit('Buscar', array("class" => "OwBuscaSubmit"));
        if (isset($opcoes['beforeCloseForm'])) {
            $html .= $opcoes['beforeCloseForm'];
        }
        $html .= '</form>';
        $html .= '</div>';

        return $html;
    }

    public function getValorCampo($campo, $atributo = null) {
        if(empty($atributo)){
            $atributo = 'valor';
        }
        
        $dados = $this->_View->get('OwBuscaViewData');
        if (empty($dados)) {
            return null;
        }

        foreach ($dados['OwBusca'] as $dado) {
            if ($dado['campo'] == $campo) {
                if (isset($dado[$atributo])) {
                    return $dado[$atributo];
                }
            }
        }

        return null;
    }

    private function _setarValorCampo(&$campo) {
        if ($campo['value'] === null && !empty($campo['default'])) {
            $campo['value'] = $campo['default'];
        }
    }

    private function _adicionarScripts() {
        $this->Html->css('OwBusca.busca.css?v=3', array('block' => true));
        $this->Html->script('OwBusca.onload.js?v=3', array('block' => true));
    }

    private function _removerCamposDoSchema($schema) {
        unset($schema['id'], $schema['created'], $schema['updated']
        );

        foreach ($schema as $k => $v) {
            if (preg_match('/.+_id$/', $k)) {
                unset($schema[$k]);
            }
        }

        return $schema;
    }

    public function getSelectLimit($options = array()) {
        if (isset($options['options'])) {
            $options['options'] = array_combine($options['options'], $options['options']);
        } else {
            $options['options'] = array('10' => '10', '20' => '20', '50' => '50', '100' => '100', '500' => '500');
        }

        if (!isset($options['default'])) {
            $controller = $this->_View->request->params['controller'];
            $options['default'] = $this->_View->request->params['paging'][$controller]['perPage'];
        }

        //se nao tiver a opcao default, adiciona ela
        if (!isset($options['options'][$options['default']])) {
            $options['options'][$options['default']] = $options['default'];
        }

        if (!isset($options['label'])) {
            $options['label'] = 'Resultados por página';
        }

        $html = '<div class="OwBuscaLimit">';
        $html .= $this->Form->input('OwBuscaLimit.limit', $options);
        $html .= '</div>';
        return $html;
    }

    public function getURL($url, $conditions) {
        $o = new OwBuscaComponent(new ComponentCollection());
        return $o->getURL($url, $conditions);
    }

}
