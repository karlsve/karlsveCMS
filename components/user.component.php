<?php

namespace components\user {
    
    class UserManagement {
        
    }
    
    class User {
        
        private $id = 0;
        private $data = array();
        
        public function __construct($id) {
            $this->id = $id;
            $this->load();
        }
        
        public function load() {
            $db = \components\database\DatabaseFactory::getDatabase();
            $db->select('user', '*', "id={$this->id}");
        }
        
        public function get($key) {
            if(key_exists($key, $this->data)) {
                return $this->data[$key];
            }
            trigger_error("Value '{$key}' not found for User {$this->id}.");
            return false;
        }
    }
    
}