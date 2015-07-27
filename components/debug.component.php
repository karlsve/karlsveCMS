<?php

namespace components\debug {

    function init_error_handling() {
        if (\components\configuration\ConfigurationFactory::getInstance()->get('debugger', 0) !== 0) {
            set_error_handler('\components\debug\error_handler');
        }
    }

    function error_handler($errno, $errstr, $errfile, $errline) {
        if (!(error_reporting() & $errno)) {
            // This error code is not included in error_reporting
            return;
        }
        Debug::addError(new Error($errno, $errstr, $errfile, $errline));
    }

    abstract class Debug {

        private static $errors = array();

        public static function addError($error) {
            if ($error instanceof Error) {
                self::$errors[] = $error;
            }
        }

        public static function hasErrors() {
            return !empty(self::$errors);
        }

        public static function getErrors() {
            return self::$errors;
        }

    }

    class Error {

        private $number = 0;
        private $string = '';
        private $file = '';
        private $line = 0;

        public function __construct($errno, $errstr, $errfile, $errline) {
            $this->number = $errno;
            $this->string = $errstr;
            $this->file = $errfile;
            $this->line = $errline;
        }

        public function getNumber() {
            return $this->number;
        }

        public function getString() {
            return $this->string;
        }

        public function getFile() {
            return $this->file;
        }

        public function getLine() {
            return $this->line;
        }

    }

}