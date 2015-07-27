<?php

namespace components\input {

    /**
     * Access to GET and POST input
     * @category components
     * @author karlsve
     * @abstract
     */
    abstract class Input {

        /**
         * 
         * @access private
         * @static
         * @var string[] List of GET
         */
        private static $GET = array();

        /**
         * 
         * @access private
         * @static
         * @var string[] List of POST
         */
        private static $POST = array();

        /**
         * 
         * @access private
         * @static
         * @var string[] List of GET and POST
         */
        private static $ALL = array();

        /**
         * @static
         * @access private
         */
        private static function load() {
            self::loadGET();
            self::loadPOST();
            if (empty(self::$ALL)) {
                self::$ALL = array_merge(self::$GET, self::$POST);
            }
        }

        /**
         * @static
         * @access private
         */
        private static function loadGET() {
            if (empty(self::$GET)) {
                self::$GET = filter_input_array(INPUT_GET);
            }
        }

        /**
         * @static
         * @access private
         */
        private static function loadPOST() {
            if (empty(self::$POST)) {
                self::$POST = filter_input_array(INPUT_POST);
            }
        }

        /**
         * 
         * @param string $key Key to check for in $ALL
         * @return type
         */
        public static function has($key) {
            self::load();
            if(empty(self::$ALL)) {
                return false;
            }
            return key_exists($key, self::$ALL);
        }

        /**
         * 
         * @param string $key Key to get from $ALL
         * @return type
         */
        public static function get($key, $default = '') {
            self::load();
            if (!self::has($key)) {
                return $default;
            }
            return self::$ALL[$key];
        }

        /**
         * 
         * @param string $key Key to check for in $GET
         * @return type
         */
        public static function hasGET($key) {
            self::loadGET();
            if(empty(self::$GET)) {
                return false;
            }
            return key_exists($key, self::$GET);
        }

        /**
         * 
         * @param string $key Key to get from $GET
         * @return type
         */
        public static function getGET($key, $default = '') {
            self::loadGET();
            if (!self::hasGET($key)) {
                return $default;
            }
            return self::$GET[$key];
        }

        /**
         * 
         * @param string $key Key to check for in $POST
         * @return type
         */
        public static function hasPOST($key) {
            self::loadPOST();
            if(empty(self::$POST)) {
                return false;
            }
            return key_exists($key, self::$POST);
        }

        /**
         * 
         * @param string $key Key to get from $POST
         * @return type
         */
        public static function getPOST($key, $default = '') {
            self::loadPOST();
            if (!self::hasPOST($key)) {
                return $default;
            }
            return self::$POST[$key];
        }

    }

}
