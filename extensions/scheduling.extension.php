<?php

namespace extensions\scheduling {
    
    abstract class SchedulingFactory {
        public static function getInstance($scheduler, $data) {
            
        }
    }
    
    abstract class Scheduler {
        private $data = array();
        protected $schedule = array();
        
        public function __construct($data) {
            $this->data = $data;
        }
        
        public function getData() {
            return $this->data;
        }
        
        public function getSchedule() {
            return $this->schedule;
        }
        
        protected abstract function generateSchedule();
        public abstract function getName();
    }
    
    class FIFO extends Scheduler {
        
        protected function generateSchedule() {
            
        }

        public function getName() {
            
        }

    }
    
    class RR extends Scheduler {
        
        protected function generateSchedule() {
            
        }

        public function getName() {
            
        }

    }
    
}