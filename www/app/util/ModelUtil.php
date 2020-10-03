<?php

/**
 * Description of ModelUtil
 *
 * @author raphael
 */
class ModelUtil {
    
    function searchIdInResultSet($resultSet, $id) {            
        $resultSet->rewind();
        while ( $resultSet->valid() ) {
            if ($resultSet->current()->id == $id) {
                return TRUE;
            }
            $resultSet->next();
        }
        return FALSE;
    }
    
}
