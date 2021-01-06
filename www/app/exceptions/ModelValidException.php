<?php

use Phalcon\Forms\Form as Validator;

/**
 * Description of ModelValidException
 *
 * @author raphael
 */
class ModelValidException extends Exception {
    
    /**
     *
     * @var Validator
     */
    private $validator;
    
    public function __construct(Validator $validator, int $code = 0, \Throwable $previous = null) {
        $this->validator = $validator;
        parent::__construct('ModelValidException', $code, $previous);
    }
    
    function getValidator() {
        return $this->validator;
    }
    
}
