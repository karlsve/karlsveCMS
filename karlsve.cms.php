<?php

namespace {

    define('BASE_DIR', dirname(__FILE__) . '/');

    KarlsveCMS::getInstance();

    class KarlsveCMS {

        private static $instance = null;

        public static function getInstance() {
            if (self::$instance == null) {
                self::$instance = new KarlsveCMS();
            }
            return self::$instance;
        }

        private $components = array();
        private $extensions = array();

        private function __construct() {
            $this->loadComponents();
            $this->loadExtensions();
            echo components\view\ViewFactory::get('default.view.php');
        }

        private function loadComponents() {
            $this->components = glob(BASE_DIR . 'components/*.component.php');
            foreach ($this->components as $component) {
                require_once $component;
            }
        }

        public function getComponents() {
            return $this->components;
        }

        private function loadExtensions() {
            $this->extensions = glob(BASE_DIR . 'extensions/*.extension.php');
            foreach ($this->extensions as $extension) {
                include_once $extension;
            }
        }

        public function getExtensions() {
            return $this->extensions;
        }

    }

}