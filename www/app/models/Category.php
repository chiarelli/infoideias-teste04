<?php

use Phalcon\Db\Column;
use Phalcon\Mvc\Model;

class Category extends Model {

    /**
     *
     * @var integer
     * @Primary
     * @Column(type="integer", length=10, nullable=false)
     */
    public $id;

    /**
     *
     * @var string
     * @Column(type="string", length=45, nullable=true)
     */
    public $name;

    /**
     * Initialize method for model.
     */
    public function initialize() {
        $this->setSchema("phalcont_teste04");
        $this->hasMany('id', 'NoticiaCategory', 'category_id', ['alias' => 'NoticiaCategory']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource() {
        return 'category';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Category[]|Category
     */
    public static function find($parameters = null) {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Category
     */
    public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }

}
