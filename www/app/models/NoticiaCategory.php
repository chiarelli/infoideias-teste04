<?php

use Phalcon\Db\Column;
use Phalcon\Mvc\Model;

class NoticiaCategory extends Model {

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=10, nullable=false)
     */
    public $id;

    /**
     *
     * @var integer
     * @Column(type="integer", length=10, nullable=false)
     */
    public $noticia_id;

    /**
     *
     * @var integer
     * @Column(type="integer", length=10, nullable=false)
     */
    public $category_id;

    /**
     * Initialize method for model.
     */
    public function initialize() {
        $this->setSchema("phalcont_teste04");
        $this->belongsTo('noticia_id', '\Noticia', 'id', ['alias' => 'Noticia']);
        $this->belongsTo('category_id', '\Category', 'id', ['alias' => 'Category']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource() {
        return 'noticia_category';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return NoticiaCategory[]|NoticiaCategory
     */
    public static function find($parameters = null) {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return NoticiaCategory
     */
    public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }

}
