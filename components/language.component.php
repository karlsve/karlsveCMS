<?php

namespace components\language {

    abstract class Language {

        private static $translations = array();

        private static function load() {
            if (empty(self::$translations)) {
                $language_files = glob(BASE_DIR . 'languages/*.language.php');
                foreach ($language_files as $language_file) {
                    include_once $language_file;
                }
            }
        }

        public static function addLanguage($language, $translation) {
            if (!empty($language)) {
                if (!empty($translation)) {
                    if (!self::hasLanguage($language)) {
                        self::$translations[$language] = $translation;
                    } else {
                        $temp = self::$translations[$language];
                        self::$translations[$language] = array_merge($temp, $translation);
                    }
                } else {
                    trigger_error("No translation specified.");
                }
            } else {
                trigger_error("No language specified.");
            }
        }

        public static function hasLanguage($language) {
            self::load();
            return key_exists($language, self::$translations);
        }

        public static function hasTranslation($key, $language) {
            if (self::hasLanguage($language)) {
                return key_exists($key, self::$translations[$language]);
            }
            return false;
        }

        public static function translate($key, $language = 'en', $force = false) {
            if(!$force && \components\input\Input::hasGET('lang')) {
                $language = \components\input\Input::getGET('lang');
            }
            if (self::hasTranslation($key, $language)) {
                return self::$translations[$language][$key];
            } else {
                return self::translateGlobal($key);
            }
            return $key;
        }

        public static function translateGlobal($key) {
            foreach(self::$translations as $language) {
                if(key_exists($key, $language)) {
                    return $language[$key];
                }
            }
            return false;
        }

    }

}