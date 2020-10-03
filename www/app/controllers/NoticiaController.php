<?php

use Phalcon\Flash\Session as FlashSession;

class NoticiaController extends ControllerBase {

    /**
     *
     * @var FlashSession 
     */
    private $flash;

    public function listaAction() {
        
        $noticiasIt = Noticia::find();
        
        $this->view->setVar('noticiasIt', $noticiasIt);
        
        $this->view->pick("noticia/listar");
    }

    public function cadastrarAction() {

        $this->view->pick("noticia/cadastrar");
    }

    public function editarAction($id) {        
        $noticia = Noticia::findFirst((int) $id);
        
        if( FALSE === $noticia ) {
            $this->getFlash()->message('error', 'Essa Notícia não existe na base de dados.');
            $this->view->setVar( 'noticia', new Noticia );
            return $this->view->pick("noticia/editar");
        }
        
        $this->view->setVar('noticia', $noticia);
        $this->view->pick("noticia/editar");
    }
    
    public function updateAction() {
        $id = $this->request->get('id');
        
        if( ! $this->isUpdateRequestValid() ) {
            return $this->response->redirect(array('for' => 'noticia.editar', 'id' => $id));
        }
        
        $noticia = Noticia::findFirst($id);
        
        if( ! $noticia ) {
            $this->getFlash()->message('error', "A notícia id #{$id} não é elegível para edição.");
            return $this->response->redirect(array('for' => 'noticia.lista'));
        }
        
        $noticia->titulo = $this->request->get('titulo');
        $noticia->texto = $this->request->get('texto');
        $noticia->data_ultima_atualizacao = date('Y-m-d H:i:s');        
        
        if ( ! $noticia->update() ) {
            $this->getFlash()->message('error', 'Houve um erro ao editar a notícia. Por favor, tente novamente.');
            return $this->response->redirect(array('for' => 'noticia.editar', 'id' => $id));
        }
        $this->getFlash()->message('success', "Notícia id #{$id} editada com sucesso");
        
        return $this->response->redirect(array('for' => 'noticia.lista'));
    }

    public function salvarAction() {        
        if( ! $this->isUpdateRequestValid() ) {
            return $this->response->redirect(array('for' => 'noticia.cadastrar'));
        }
        
        $date_created = date('Y-m-d H:i:s');

        $noticia = new Noticia(array(
            'titulo' => $this->request->get('titulo'),
            'texto' => $this->request->get('texto'),
            'data_cadastro' => $date_created,
            'data_ultima_atualizacao' => $date_created,
        ));

        if (!$noticia->save()) {
            $this->getFlash()->message('error', 'Houve um erro ao salvar a notícia. Por favor, tente novamente.');
            return $this->response->redirect(array('for' => 'noticia.cadastrar'));
        }

        $this->getFlash()->message('success', 'Notícia cadastrada com sucesso');

        return $this->response->redirect(array('for' => 'noticia.lista'));
    }
    
    protected function isUpdateRequestValid() {
        if (false === $this->request->isPost()) {
            return false;
        }

        $form = new NoticiaUpdateForm();

        if (!$form->isValid($this->request->getPost())) {
            $messages = $form->getMessages();

            foreach ($messages as $message) {
                $this->getFlash()->message('error', $message);
            }

            return false;
        }
        
        return true;
    }

    public function excluirAction($id) {
        return $this->response->redirect(array('for' => 'noticia.lista'));
    }

    /**
     * 
     * @return FlashSession
     */
    protected function getFlash() {
        return $this->flash = $this->flash ?: new FlashSession();
    }

}
