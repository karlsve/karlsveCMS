<?php

namespace components\database {
    

    /**
     * Factory to get database instances
     * @category components
     * @author karlsve
     * @abstract
     */
    abstract class DatabaseFactory {
        
        /**
         * 
         * @access private
         * @static
         * @var Database[] List of database instances
         */
        private static $databases = array();
        
        /**
         * 
         * @access private
         * @static
         * @var string[] List of database classes
         */
        private static $types = array (
            'sqlite' => 'components\database\SQLiteDatabase'
        );
        
        /**
         * Get Database instance
         * Default parameter is 'sqlite'
         * @param string $type
         * @return Database Database instance
         */
        public static function getDatabase($type = 'sqlite') {
            if(!key_exists($type, self::$databases)) {
                if(!key_exists($type, self::$types)) {
                    return false;
                }
                self::$databases[$key] = new self::$types[$type]();
                return self::$databases[$key];
            }
            return self::$databases[$key];
        }
        
        /**
         * Requires Classname to include namespace
         * @param string $type
         * @param string $class
         */
        public static function addType($type, $class) {
            self::$types[$type] = $class;
        }
    }
    
    /**
     * Abstract Database to base other DB types on
     * @abstract
     */
    abstract class Database {
        public function __construct() {
            $this->connect();
        }
        protected abstract function connect();
        protected abstract function query($query);
        protected abstract function select($table, $columns, $filter);
        protected abstract function insert($table, $columns, $values);
        protected abstract function update($table, $data, $filter);
        protected abstract function delete($table, $filter);
    }
    
    class SQLiteDatabase extends Database {
        
        private $handle = null;
        
        protected function connect() {
            $this->handle = new \SQLite3('sqlite.db');
        }

        protected function delete($table, $filter) {
            $result = $this->handle->query("DELETE FROM {$table} WHERE {$filter}");
            if($result) {
                return true;
            }
            trigger_error($this->handle->lastErrorMsg());
            return false;
        }

        protected function insert($table, $columns, $values) {
            $success = $this->handle->query("INSERT INTO {$table} ({$columns}) VALUES ({$values})");
            if($success) {
                return $this->handle->lastInsertRowID();
            }
            trigger_error($this->handle->lastErrorMsg());
            return false;
        }

        protected function query($query) {
            $result = $this->handle->query($query);
            if($result) {
                return $result;
            }
            trigger_error($this->handle->lastErrorMsg());
            return false;
        }

        protected function select($table, $columns, $filter = '') {
            $result = $this->handle->query("SELECT {$columns} FROM {$table}" . !empty($filter) ? " WHERE {$filter}" : '');
            if($result) {
                $data = array();
                while(($row = $result->fetchArray()) != false) {
                    $data[] = $row;
                }
                return $data;
            }
            trigger_error($this->handle->lastErrorMsg());
            return false;
        }

        protected function update($table, $data, $filter) {
            return $this->handle->query("UPDATE {$table} SET ({$data}) WHERE {$filter}");
        }

    }
    
}