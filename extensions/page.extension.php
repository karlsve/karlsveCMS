<?php

namespace extensions\pages {

    abstract class PageFactory {

        private static $pages = array();

        private static function load() {
            if (empty(self::$pages)) {
                $pages = glob(BASE_DIR . 'extensions/pages/*.page.php');
                foreach ($pages as $page) {
                    $key = str_replace('.page.php', '' ,str_replace(BASE_DIR . 'extensions/pages/', '', $page));
                    self::$pages[$key] = $page;
                }
            }
        }

        public static function has($page) {
            self::load();
            return key_exists($page, self::$pages);
        }

        public static function get($page) {
            self::load();
            if (self::has($page)) {
                ob_start();
                include self::$pages[$page];
                return ob_get_clean();
            }
            return 'Page not found.';
        }

    }

}