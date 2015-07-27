<?php

namespace components\math {

    class Formula {

        private $text = '';
        private $solvable = '';
        private $children = array();
        private $solution = 0;

        public function __construct($text) {
            $this->text = $text;
            if (stripos($this->text, '(') !== false) {
                $this->split();
            }
            $this->calculate();
        }

        private function split() {
            $chars = str_split($this->text);
            $lvl = 0;
            $temp = '';
            foreach ($chars as $char) {
                if ($char == '(') {
                    $lvl++;
                } elseif ($char == ')') {
                    $lvl--;
                }
                if (!preg_match('!\\(|\\)!', $char)) {
                    if ($lvl == 0 && !empty($temp)) {
                        $this->children[] = new Formula($temp);
                        $temp = '';
                    } else {
                        $temp .= $char;
                    }
                }
            }
            if (!empty($temp)) {
                $this->children[] = new Formula($temp);
            }
        }

        private function calculate() {
            $text = $this->getText();
            foreach ($this->getChildren() as $child) {
                $text = str_replace('('.$child->getText().')', $child->getSolution(), $text);
            }
            $this->solvable = $text;
            $this->calculateText();
        }

        private function calculateText() {
            $chars = str_split($this->solvable);
            $operator = '+';
            $temp = '';
            foreach ($chars as $char) {
                if (preg_match('#\\+|-|\\*|\\/#', $char) && !empty($temp)) {
                    $this->operate($operator, $temp);
                    $operator = $char;
                    $temp = '';
                } else {
                    $temp .= $char;
                }
            }
            if (!empty($temp)) {
                $this->operate($operator, $temp);
            }
        }

        private function operate($operator, $value) {
            $temp = intval($value);
            switch ($operator) {
                case '+':
                    $this->add($temp);
                    break;
                case '-':
                    $this->subtract($temp);
                    break;
                case '*':
                    $this->multiply($temp);
                    break;
                case '/':
                    $this->divide($temp);
                    break;
            }
        }

        private function add($value) {
            $this->solution += intval($value);
        }

        private function subtract($value) {
            $this->solution -= intval($value);
        }

        private function multiply($value) {
            $this->solution = $this->solution * intval($value);
        }

        private function divide($value) {
            $this->solution = $this->solution / intval($value);
        }

        public function getText() {
            return $this->text;
        }
        
        public function getSolvable() {
            return $this->solvable;
        }

        public function getSolution() {
            return $this->solution;
        }

        public function getChildren() {
            return $this->children;
        }

    }

}