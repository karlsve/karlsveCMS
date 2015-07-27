<?php

namespace components\utilites {

    abstract class String {

        public static function remove_utf8_bom($text) {
            $bom = pack('H*', 'EFBBBF');
            $text = preg_replace("/^$bom/", '', $text);
            return $text;
        }

    }

    abstract class JSON {

        public static function sanitizeLeadingZeroes($text) {
            return preg_replace('/(?<=:)\s*0+(?=[1-9])/', '', $text);
        }

        public static function create($json_text) {
            $json_text_bomfree = String::remove_utf8_bom($json_text);
            $json = json_decode($json_text_bomfree, false, 512, JSON_BIGINT_AS_STRING);
            if (json_last_error() !== JSON_ERROR_NONE):
                trigger_error(json_last_error_msg());
            endif;
            return $json;
        }

        public static function createArray($json_text) {
            $json_text_bomfree = String::remove_utf8_bom($json_text);
            $json_text_bomfree_sanitized_zeroes = self::sanitizeLeadingZeroes($json_text_bomfree);
            $json = json_decode($json_text_bomfree_sanitized_zeroes, true);
            if (json_last_error() !== JSON_ERROR_NONE):
                trigger_error(json_last_error_msg());
            endif;
            return $json;
        }

    }

    abstract class CURL {

        public static function url_get_contents($url) {
            if (!function_exists('curl_init')) {
                die('CURL is not installed!');
            }
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            $output = curl_exec($ch);
            if (curl_errno($ch)) {
                trigger_error(curl_error($ch));
            }
            curl_close($ch);
            return $output;
        }

    }

}