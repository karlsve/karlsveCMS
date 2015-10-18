<?php

namespace extensions\pages {

    abstract class PageFactory {

        private static $pages = array();

        private static function load() {
            if (empty(self::$pages)) {
                $pages = glob(BASE_DIR . 'extensions/pages/*.page.php');
                foreach ($pages as $page) {
                    $page_object = new FilePage($page);
                    self::$pages[$page_object->getName()] = $page_object;
                }
            }
        }

        public static function has($key) {
            self::load();
            return key_exists($key, self::$pages);
        }

        public static function get($key) {
            self::load();
            if (self::has($key)) {
                return self::$pages[$key]->getContent();
            }
            return 'Page not found.';
        }

    }
    
    abstract class Page {
        public abstract function getName();
        public abstract function getContent();
    }
    
    class FilePage extends Page {
        
        private $filename = '';
        private $content = '';
        private $name = '';
        
        public function __construct($filename) {
            $this->filename = $filename;
            $this->name = str_replace('.page.php', '' ,str_replace(BASE_DIR . 'extensions/pages/', '', $this->filename));
        }
        
        public function getContent() {
            if(empty($this->content)) {
                ob_start();
                include $this->filename;
                $this->content = ob_get_clean();
            }
            return $this->content;
        }

        public function getName() {
            return $this->name;
        }

    }
    
    class DatabasePage extends Page {
        
        private $db = null;
        
        public function __construct($id) {
            $this->id = $id;
            $this->db = \components\database\DatabaseFactory::getDatabase();
        }
        
        public function getContent() {
            $pages = $db->select('pages', '*', "id={$this->id}");
            if($pages) {
                return $pages[0]['content'];
            }
        }

        public function getName() {
            $pages = $db->select('pages', '*', "id={$this->id}");
            if($pages) {
                return $pages[0]['name'];
            }
        }

    }

}