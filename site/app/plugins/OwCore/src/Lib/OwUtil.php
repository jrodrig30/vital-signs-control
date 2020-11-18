<?php
namespace OwCore\Lib;

class OwUtil{
    const ER_DATA_BR = '/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{2}|[0-9]{4})$/';
    const ER_DATA_ISO = '/^([0-9]{2}|[0-9]{4})\-([0-9]{1,2})\-([0-9]{1,2})$/';

    public static function isDataBR($data){
        return preg_match(self::ER_DATA_BR, $data);
    }

    public static function isDataISO($data){
        return preg_match(self::ER_DATA_ISO, $data);
    }

    public static function dataBRToISO($data){
        return preg_replace(self::ER_DATA_BR, '\\3-\\2-\\1', $data);
    }

    public static function dataISOToBR($data){
        return preg_replace(self::ER_DATA_ISO, '\\3/\\2/\\1', $data);
    }
}