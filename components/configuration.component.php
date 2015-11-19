<?php

namespace components\configuration {

    abstract class ConfigurationFactory {

        private static $loaded = array();

        public static function getInstance($type = '\components\configuration\BasicConfiguration', $file = 'default.config') {
            if (!key_exists($type, self::$loaded)) {
                self::$loaded[$type] = array();
            }
            if (!key_exists($file, self::$loaded[$type])) {
                self::$loaded[$type][$file] = new $type(BASE_DIR . $file);
            }
            return self::$loaded[$type][$file];
        }

    }

    abstract class AbstractConfiguration {

        private $file = '';
        private $data = array();

        public function __construct($file) {
            $this->file = $file;
            $this->data = $this->load();
        }

        public abstract function load();

        public function getFile() {
            return $this->file;
        }

        public function getData() {
            return $this->data;
        }

        public function has($section, $key) {
            return key_exists($section, $this->data) ? key_exists($key, $this->data[$section]) : false;
        }

        public function get($section, $key, $default = '') {
            if ($this->has($section, $key)) {
                return $this->data[$section][$key];
            }
            return $default;
        }

    }

    class BasicConfiguration extends AbstractConfiguration {

        public function load() {
            return parse_ini_file($this->getFile(), true);
        }

    }

}