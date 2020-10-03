<?php

use Phalcon\Flash\Session as FlashSession;

class NoticiaController extends ControllerBase {

    /**
     *
     * @var FlashSession 
     */
    private $flash;

    public function listaAction() {

        $this->view->pick("noticia/listar");
    }

    public function cadastrarAction() {

        $this->view->pick("noticia/cadastrar");
    }

    public function editarAction($id) {
        $this->view->pick("noticia/editar");
    }

    public function salvarAction() {
        if (false === $this->request->isPost()) {
            // Não faz nada, sai silenciosamente
            return;
        }

        $form = new NoticiaUpdateForm();

        if (!$form->isValid($this->request->getPost())) {
            $messages = $form->getMessages();

            foreach ($messages as $message) {
                $this->getFlash()->message('error', $message);
            }

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
