<?php

namespace extensions\ogame {

    class OGameUser {

        private $id = '';

        public function __construct($id) {
            $this->id = $id;
        }

    }

    class OGamePlanet {

        private $id = '';

        public function __construct($id) {
            $this->id = $id;
        }

    }

    abstract class OGameAPI {

        private static $data = array(
            'universes' => array(
                'url' => 'http://%s.ogame.gameforge.com/api/universes.xml',
                'raw' => '',
                'data' => array()
            ),
            'serverData' => array(
                'url' => 'http://%s.ogame.gameforge.com/api/serverData.xml',
                'raw' => '',
                'data' => array()
            ),
            'universe' => array(
                'url' => 'http://%s.ogame.gameforge.com/api/universe.xml',
                'raw' => '',
                'data' => array()
            )
        );

        private static function load($key, $universe = 's1-de') {
            if (empty(self::$data[$key]['raw'])) {
                $url = sprintf(self::$data[$key]['url'], $universe);
                trigger_error($url);
                $raw = \components\utilites\CURL::url_get_contents($url, true);
                trigger_error(\components\utilites\Prettify::dump($raw));
                self::$data[$key]['raw'] = $raw;
            }
        }

        public static function getAPI($key, $universe = 's1-de') {
            self::load($key, $universe);
            return self::$data[$key];
        }

    }

}

