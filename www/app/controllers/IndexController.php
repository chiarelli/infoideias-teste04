<?php


class IndexController extends ControllerBase
{

    public function initialize()
    {
        return parent::initialize(); // TODO: Change the autogenerated stub
    }

    public function indexAction()
    {
        
        $this->view->disable();
        echo $this->view->getRender('usuario', 'login');
    }

    public function notFoundAction()
    {
        $this->view->disable();

        if($this->session->has('auth')){
            echo $this->view->getRender('layouts', '404');
        }else{
            echo $this->view->getRender('usuario', 'login');
        }

    }

}

