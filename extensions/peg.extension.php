<?php

namespace extensions\peg {
    
    class Condensator {
        
        //const EPSILON_NULL = 8.854187817 * (10^(-12));
        private $U = 0;
        private $d = 0;
        private $A = 0;
        private $C = 0;
        private $Q = 0;
        
        public function __construct($U = 0, $d = 0, $A = 0, $C = 0, $Q = 0) {
            $this->U = $U;
            $this->d = $d;
            $this->A = $A;
            $this->C = $C;
            $this->Q = $Q;
        }
        
        public function getU() {
            if($this->U == 0) {
                $this->U = $this->getQ() / $this->getC();
            }
            return $this->U;
        }
        
        public function getC() {
            if($this->C == 0) {
                $this->C = self::EPSILON_NULL * ($this->getA() / $this->getd());
            }
            return $this->Q;
        }
        
        public function getA() {
            if($this->A == 0) {
                $this->A = $this->getd() * ($this->getC() / self::EPSILON_NULL);
            }
            return $this->A;
        }
        
        public function getd() {
            if($this->d == 0) {
                $this->d = ($this->getA() * self::EPSILON_NULL) / $this->getC();
            }
            return $this->d;
        }
        
        public function getQ() {
            if($this->Q == 0) {
                $this->Q = $this->getC() * $this->getU();
            }
            return $this->Q;
        }
    }
    
}