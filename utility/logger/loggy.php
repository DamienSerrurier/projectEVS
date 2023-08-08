<?php

class Loggy {

    public static function loggy($message, GravityDegrees $level) {
        $file = 'loggy.log';

        function getDegree(GravityDegrees $degree) {
            return $degree->name;
        }

        $degree = getDegree($level);
        $date = date('Y-m-d H:i:s');
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3);

        if (isset($backtrace[2]['class'])) {
            $class = isset($backtrace[2]['class']) ? $backtrace[2]['class'] : '';
            $methode = isset($backtrace[2]['function']) ? $backtrace[2]['function'] : '';
            $message = $message . " dans la classe [{$class}], dans la méthode [{$methode}]";
        }
        else if (isset($backtrace[2]["function"])) {
            $methode = isset($backtrace[2]['function']) ? $backtrace[2]['function'] : '';
            $message = $message . " dans la méthode [{$methode}]";
        }

        $data = $degree . " " . $message . " " . $date . "\n";
        file_put_contents($file, $data, FILE_APPEND);
    }

    public static function error($message) {
        Loggy::loggy($message, GravityDegrees::Error);
    }

    public static function warning($message) {
        Loggy::loggy($message, GravityDegrees::Warning);
    }

    public static function info($message) {
        Loggy::loggy($message, GravityDegrees::Info);
    }

    public static function notice($message) {
        Loggy::loggy($message, GravityDegrees::Notice);
    }

    public static function debug($message) {
        Loggy::loggy($message, GravityDegrees::Debug);
    }
}

enum GravityDegrees {

    case Off;
    case Debug;
    case Notice;
    case Info;
    case Warning;
    case Error;
}
