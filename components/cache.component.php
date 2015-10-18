<?php

namespace components\cache {
    
    abstract class CacheManager {
        
        private static $caches = array();
        
        public static function getCache($key) {
            if(!key_exists($key, self::$caches)) {
                self::$caches[$key] = new Cache();
            }
            return self::$caches[$key];
        }
        
    }
    
    class Cache {
        
        private $data = array();
        
        public function put($key, $value) {
            $this->data[$key] = $value;
        }
        
        public function get($key) {
            return $this->data[$key];
        }
        
        public function has($key) {
            return key_exists($key, $this->data);
        }
        
    }
    
}
