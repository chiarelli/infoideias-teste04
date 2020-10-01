<?php



use Phalcon\Mvc\Model;
use Phalcon\Paginator\Adapter\Model as Paginator;

class Noticia extends Model
{

    public function initialize()
    {
        $this->setSource("noticia");
    }

    
}