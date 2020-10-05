<?php

use NoticiaUpdateForm as NoticiaValidator;
use Phalcon\Mvc\ControllerInterface as PhalconCore;
use Phalcon\Mvc\Model\Resultset;

/**
 * Description of NoticiaBO
 *
 * @author raphael
 */
class NoticiaBO {
    
    /**
     *
     * @var PhalconCore
     */
    protected $phalcon;
    
    public function __construct(PhalconCore $phalcon) {
        $this->phalcon = $phalcon;
    }
    
    public function get($id) {
        return Noticia::findFirst((int) $id);
    }
    
    /**
     * 
     * @param type $parameters
     * @return Resultset
     */
    public function find($parameters = null): Resultset {        
        return Noticia::find($parameters);
    }
    
    public function create($data) {
        $date_created = date('Y-m-d H:i:s');

        $noticia = new Noticia(array(
            'titulo' => @$data['titulo'],
            'texto' => @$data['texto'],
            'data_cadastro' => $date_created,
            'data_ultima_atualizacao' => $date_created,
        ));
        
        $this->save($noticia, $data);
    }
    
    public function update($id, $data) {        
        $noticia = Noticia::findFirst($id);
        
        if( ! $noticia ) {
            throw new Exception();
        }
        
        $noticia->titulo = @$data['titulo'];
        $noticia->texto = @$data['texto'];
        $noticia->data_ultima_atualizacao = date('Y-m-d H:i:s'); 
        
        $this->save($noticia, $data);        
    }
    
    public function delete($id) {
        $noticia = Noticia::findFirst((int) $id);
        
        if( ! $noticia ) {
            throw new Exception();
        }        
        
        // Start a transaction
         $this->phalcon->db->begin();
        
        self::cleanCategoriesOfModel($noticia);
        
        if( ! $noticia->delete() ) {            
            // Rollback the transaction
             $this->phalcon->db->rollback();
             
             throw new Exception();
        }        
        
        // Commit the transaction
        $this->phalcon->db->commit();
    }
    
    protected function save($noticia, $data) {        
        $validate = new NoticiaValidator;
        
        if( ! $validate->isValid($data) ) {
            throw new ModelValidException( $validate );
        }
        
        if( @$data['publicar'] == 'on' )
            self::insertPublicationDate($noticia, @$data['publication_date'] );
        
        $cat_ids = is_array( @$data['categories'] ) ? @$data['categories'] : [];
        
        
        // Start a transaction
        $this->phalcon->db->begin();

        if ( ! $noticia->save() || ! self::saveCategoriesInModel($noticia, $cat_ids) ) {
            // Rollback the transaction
            $this->phalcon->db->rollback();            
            throw new Exception();
        }
        
        // Commit the transaction
        $this->phalcon->db->commit();
    }
    
    static function insertPublicationDate(Noticia $noticia, $date) {
        if( $date = DateTime::createFromFormat('Y-m-d\TH:i', $date) ) {
            $noticia->data_publicacao = $date->format('Y-m-d H:i:s');
            return TRUE;
        }
        return FALSE;
    }
    
    static function saveCategoriesInModel(Noticia $noticia, array $cat_ids) {        
        self::cleanCategoriesOfModel($noticia);
        
        foreach ($cat_ids as $id) {
            /* @var $category Category */
            if( ! ($category = Category::findFirst($id)) )
                continue;
            
            $relationship = new NoticiaCategory(array(
                'noticia_id'  => $noticia->id,
                'category_id' => $category->id,
            ));
            
            if( ! $relationship->save() ) {
                return false;
            }
            
        }
        
        return true;
    }
    
    static function cleanCategoriesOfModel(Noticia $noticia) {
        $relationship = NoticiaCategory::find( "noticia_id= {$noticia->id}" );

        $relationship->rewind();        
        while ( $relationship->valid() ) {
            $relationship->current()->delete();
            
            $relationship->next();
        }        
    }
    
}
