<?php 

Class GenericObject {

    private static $object;
    private static $key;
    private static $dataIn;
    private static $dataOut;
    private static $arrayData = [];

    public static function init($object, $dataIn, $dataOut, $arrayData, $key) {
        self::setObject($object);
        self::setDataIn($dataIn);
        self::setDataOut($dataOut);
        self::setArrayData($arrayData);
        self::setKey($key);
        self::$arrayData[self::$key] = self::$dataOut;
    }

    public static function getObject() {
        return self::$object;
    }

    public static function setObject($object) {
        self::$object = $object;
    }

    public static function getKey() {
        return self::$key;
    }

    public static function setKey($key) {
        self::$key = $key;
    }

    public static function getDataIn() {
        return self::$dataIn;
    }

    public static function setDataIn($dataIn) {
        self::$dataIn = $dataIn;
    }

    public static function getDataOut() {
        return self::$dataOut;
    }

    public static function setDataOut($dataOut) {
        self::$dataOut = $dataOut;
    }

    public static function getArrayData() {
        return self::$arrayData;
    }

    public static function setArrayData($arrayData) {
        self::$arrayData = $arrayData;
    }
    
}