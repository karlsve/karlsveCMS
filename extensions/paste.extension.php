<?php

namespace extensions\paste {
    
    class PasteFactory {
        private static $types = array();
        
        public static function add($paste) {
            self::$types[] = $paste;
        }
        
        public function __construct() {
            $this->load();
        }

        private function load() {
            
        }

    }
    
    abstract class Paste {
        public abstract function __construct($text);
        public abstract function toString();
    }
    
}