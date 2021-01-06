<?php

use Phalcon\Db\Column;
use Phalcon\Mvc\Model;

class Noticia extends Model {
    use NoticiaTrait;

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=11, nullable=false)
     */
    public $id;

    /**
     *
     * @var string
     * @Column(type="string", length=500, nullable=true)
     */
    public $titulo;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    public $texto;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    public $data_ultima_atualizacao;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    public $data_cadastro;
    
    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    public $data_publicacao;

    /**
     * Initialize method for model.
     */
    public function initialize() {
        $this->setSchema("phalcont_teste04");
        $this->hasManyToMany(
                'id', 
                'NoticiaCategory', 
                'noticia_id', 'category_id', 
                'Category', 
                'id', 
                [ 'alias' => 'NoticiaCategory' ]
        );
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource() {
        return 'noticia';
    }    

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Noticia[]|Noticia
     */
    public static function find($parameters = null) {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Noticia
     */
    public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }

}
