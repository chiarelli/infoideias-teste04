<?php


class NoticiaController extends ControllerBase
{
    private $mensagemDeErro = '';

    public function listaAction()
    {

        $this->view->pick("noticia/listar");
    }

    public function cadastrarAction()
    {
        
        $this->view->pick("noticia/cadastrar");

    }

    public function editarAction($id)
    {
        $this->view->pick("noticia/editar");
    }

    public function salvarAction()
    {
        return $this->response->redirect(array('for' => 'noticia.lista'));
    }

     public function excluirAction($id)
     {
        return $this->response->redirect(array('for' => 'noticia.lista'));
     }

}