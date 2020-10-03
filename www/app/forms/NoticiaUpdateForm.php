<?php

use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Form;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;

/**
 * Description of NoticiaCreateForm
 *
 * @author raphael
 */
class NoticiaUpdateForm extends Form {
    
    public function initialize() {
        
        // ref. ao campo titulo
        $titulo = new Text('titulo');
        
        $titulo->addValidator(
            new PresenceOf(
                [
                    'message' => 'Campo título: é obrigatório',
                ]
            )
        );
        
        $titulo->addValidator(
            new StringLength(
                [
                    'max'            => 255,
                    'messageMaximum' => 'Campo título: a quantidade máxima de caracteres é 255',
                ]
            )
        );
        
        // ref. ao campo texto
        $texto = new Text('texto');
        
        // registrando os componentes
        $this->add($titulo);
        $this->add($texto);
    }
    
}
