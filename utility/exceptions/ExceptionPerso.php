<?php

class ExceptionPerso extends Exception {

    public function __construct(string $message) {
        parent::__construct($message);
        
    }

    public function __toString() : string {
        return __CLASS__ . "{$this->message}\n";
    }
}