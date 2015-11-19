<?php

namespace extensions\league {

    abstract class RiotAPI {

        const SUMMONER_URL = 'https://{region}.api.pvp.net/api/lol/{region}/v1.4/summoner/by-name/{summoner_name}?api_key={api_key}';
        const STATS_URL = 'https://{region}.api.pvp.net/api/lol/{region}/v1.3/stats/by-summoner/{summoner_id}/summary?season=SEASON2015&api_key={api_key}';
        const GAMES_URL = 'https://{region}.api.pvp.net/api/lol/{region}/v1.3/game/by-summoner/{summoner_id}/recent?api_key={api_key}';

        private static function getKey() {
            return \components\configuration\ConfigurationFactory::getInstance()->get('extension_riot', 'api_key');
        }

        public static function getSummonerInfo($region, $name) {
            $replacement = array('{region}' => $region, '{summoner_name}' => $name, '{api_key}' => self::getKey());
            $url = str_replace(array_keys($replacement), $replacement, self::SUMMONER_URL);
            $response = \components\utilites\CURL::url_get_contents($url);
            $json = \components\utilites\JSON::create($response);
            return $json;
        }

        public static function getSummonerStats($region, $id) {
            $replacement = array('{region}' => $region, '{summoner_id}' => $id, '{api_key}' => self::getKey());
            $url = str_replace(array_keys($replacement), $replacement, self::STATS_URL);
            $response = \components\utilites\CURL::url_get_contents($url);
            $json = \components\utilites\JSON::create($response);
            return $json;
        }

        public static function getSummonerGames($region, $id) {
            $replacement = array('{region}' => $region, '{summoner_id}' => $id, '{api_key}' => self::getKey());
            $url = str_replace(array_keys($replacement), $replacement, self::GAMES_URL);
            $response = \components\utilites\CURL::url_get_contents($url);
            $json = \components\utilites\JSON::create($response);
            return $json;
        }

    }

    class Summoner {

        private $name = '';
        private $region = '';
        private $info = null;
        private $stats = null;
        private $games = null;

        public function __construct($name, $region) {
            $this->name = strtolower(str_replace(' ', '', $name));
            $this->region = $region;
        }

        public function getInfo($key) {
            $this->loadInfo();
            return $this->info->{$this->name}->{$key};
        }

        public function getStats($key) {
            $this->loadStats();
            return $this->stats->{$key};
        }

        public function getGames() {
            $this->loadGames();
            return $this->games;
        }

        private function loadInfo() {
            if ($this->info == null) {
                $this->info = RiotAPI::getSummonerInfo($this->region, $this->name);
            }
        }

        private function loadStats() {
            if ($this->stats == null) {
                $this->stats = RiotAPI::getSummonerStats($this->region, $this->getInfo('id'));
            }
        }

        private function loadGames() {
            if ($this->games == null) {
                $this->games = RiotAPI::getSummonerGames($this->region, $this->getInfo('id'))->{'games'};
            }
        }

    }

}