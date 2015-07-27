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

        public abstract function save();

        public function getFile() {
            return $this->file;
        }

        public function getData() {
            return $this->data;
        }

        public function has($key) {
            return key_exists($key, $this->data);
        }

        public function get($key, $default = '') {
            if ($this->has($key)) {
                return $this->data[$key];
            }
            return $default;
        }

    }

    class BasicConfiguration extends AbstractConfiguration {

        public function load() {
            $data = array();
            $handle = \fopen($this->getFile(), 'r');
            while (($line = fgets($handle)) !== false) {
                $pieces = explode('=', $line);
                if (count($pieces) == 2) {
                    $key = $pieces[0];
                    $value = $pieces[1];
                    $data[$key] = $value;
                }
            }
            \fclose($handle);
            return $data;
        }

        public function save() {
            $data = $this->getData();
            $handle = \fopen($this->getFile(), 'w');
            foreach ($data as $key => $value) {
                $line = sprintf('%s=%s\n', $key, $value);
                fwrite($handle, $line);
            }
            \fclose($handle);
        }

    }

}