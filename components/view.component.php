<?php

namespace components\view {

    /**
     * Factory to get Views
     * @category components
     * @author karlsve
     * @abstract
     */
    abstract class ViewFactory {

        /**
         * 
         * @access private
         * @static
         * @var string[] List of views
         */
        private static $views = array();

        /**
         * 
         * @static
         * @access public
         * @param string $name View to get
         * @return string
         */
        public static function get($name) {
            self::loadViews();
            if (!self::hasView($name)) {
                return 'View not found.';
            }
            ob_start();
            include BASE_DIR . "views/{$name}";
            return ob_get_clean();
        }

        /**
         * 
         * @static
         * @access private
         * @param string $name
         * @return bool
         */
        private static function hasView($name) {
            return in_array($name, self::$views);
        }

        /**
         * @static
         * @access private
         */
        private static function loadViews() {
            if (empty(self::$views)) {
                $views = glob(BASE_DIR . 'views/*.view.php');
                foreach($views as $view) {
                    self::$views[] = str_replace(BASE_DIR . 'views/', '', $view);
                }
            }
        }

    }

}