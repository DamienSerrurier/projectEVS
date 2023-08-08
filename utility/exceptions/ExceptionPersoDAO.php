<?php

class ExceptionPersoDAO extends RuntimeException {

    public function __construct(string $message, $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
        
    }

    public function __toString() : string {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    } 
}