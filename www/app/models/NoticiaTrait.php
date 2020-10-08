<?php


trait NoticiaTrait {
    
    function getDateCreated($format = 'd/m/Y H:i:s') {
        return self::formatDate($format, $this->data_cadastro);
    }

    function getDateModified($format = 'd/m/Y H:i:s') {
        return self::formatDate($format, $this->data_ultima_atualizacao);
    }
    
    function getDatePublication($format = 'd/m/Y H:i:s') {
        return self::formatDate($format, $this->data_publicacao);
    }

    public static function formatDate($format, $date) {
        if( $date = DateTime::createFromFormat('Y-m-d H:i:s', $date) ) {
            return $date->format($format);
        }        
        return FALSE;
    }
    
}
