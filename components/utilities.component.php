<?php

namespace components\utilites {

    abstract class String {

        public static function remove_utf8_bom($text) {
            $bom = pack('H*', 'EFBBBF');
            return preg_replace("/^$bom/", '', $text);
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

        public static function url_get_contents($url, $debug = false) {
            if (!function_exists('curl_init')) {
                die('CURL is not installed!');
            }
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HEADER, true);

            $output = curl_exec($ch);
            if ($debug) {
                $curlinfo = curl_getinfo($ch);
                /** Blurring the local information, cuz its none of their business! **/
                $curlinfo['local_ip'] = '133.713.371.337';
                $curlinfo['local_port'] = '133.713.371.337';
                trigger_error(Prettify::dump($curlinfo), E_USER_ERROR);
            }
            $httpcode = intval(curl_getinfo($ch, CURLINFO_HTTP_CODE));
            if ($httpcode != 200) {
                trigger_error("HTTP Status Code: {$httpcode}");
            }
            if (curl_errno($ch)) {
                trigger_error(curl_error($ch));
            }
            curl_close($ch);
            return preg_replace('|.*?[\n\r]|', '', $output);
        }

    }

    abstract class Prettify {

        public static function dump($var, $force_var_dump = false) {
            ob_start();
            print_r($var);
            $print = ob_get_clean();
            if (empty($print) || $force_var_dump) {
                ob_start();
                var_dump($var);
                return ob_get_clean();
            }
            return $print;
        }

    }

}