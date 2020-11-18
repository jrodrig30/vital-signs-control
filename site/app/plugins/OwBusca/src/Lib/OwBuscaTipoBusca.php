<?php

namespace OwBusca\Lib;

class OwBuscaTipoBusca {

    const TIPO_CONTEM = 1;
    const TIPO_COMECA_COM = 2;
    const TIPO_TERMINA_COM = 3;
    const TIPO_MAIOR_QUE = 4;
    const TIPO_MENOR_QUE = 5;
    const TIPO_DIFERENTE_DE = 6;
    const TIPO_IGUAL_A = 7;
    const TIPO_ENTRE = 8;
    const TIPO_VAZIO = 9;
    const TIPO_NAO_VAZIO = 10;

    public static function tipoBuscas() {
        return array(
            self::TIPO_CONTEM => 'Contém',
            self::TIPO_COMECA_COM => 'Começa com',
            self::TIPO_TERMINA_COM => 'Termina com',
            self::TIPO_MAIOR_QUE => 'Maior que',
            self::TIPO_MENOR_QUE => 'Menor que',
            self::TIPO_DIFERENTE_DE => 'Diferente de',
            self::TIPO_IGUAL_A => 'Igual a',
            self::TIPO_ENTRE => 'Entre',
            self::TIPO_VAZIO => 'Vazio',
            self::TIPO_NAO_VAZIO => 'Não Vazio',
        );
    }

    public static function dataBRToISO($data) {
        if (!strlen($data)) {
            return '';
        }

        list($dia, $mes, $ano) = explode('/', $data);
        return sprintf('%d-%02d-%02d', $ano, $mes, $dia);
    }

    public static function isDataBR($data) {
        return preg_match('/^[0-9]{1,2}\/[0-9]{1,2}\/[0-9]{2,4}$/', $data);
    }

    public static function isDataISO($data) {
        return preg_match('/^[0-9]{2,4}\-[0-9]{1,2}\-[0-9]{1,2}$/', $data);
    }

    public static function dataISOToBR($data) {
        if (!strlen($data)) {
            return '';
        }

        list($ano, $mes, $dia) = explode('-', $data);
        return sprintf('%02d/%02d/%d', $dia, $mes, $ano);
    }

}
