<?php

use Phalcon\Flash\Session as FlashSession;

class NoticiaController extends ControllerBase {

    /**
     *
     * @var FlashSession 
     */
    private $flash;
    
    /**
     *
     * @var ModelUtil
     */
    private $utility;
    
    /**
     *
     * @var NoticiaBO
     */
    private $noticiaBO;
    
    public function initialize() {
        parent::initialize();
        
        $this->utility   = new ModelUtil();
        $this->noticiaBO = new NoticiaBO($this);
    }

    public function listaAction() {        
        $noticiasIt = $this->noticiaBO->find();
        
        $this->view->setVar('noticiasIt', $noticiasIt);
        
        $this->view->pick("noticia/listar");
    }

    public function cadastrarAction() {
        $categoriesIt = Category::find();
        
        $this->view->setVar('categoriesIt', $categoriesIt);
        
        $this->view->pick("noticia/cadastrar");
    }

    public function editarAction($id) {        
        $noticia = $this->noticiaBO->get($id);
        
        if( FALSE === $noticia ) {
            $this->getFlash()->message('error', 'Essa Notícia não existe na base de dados.');
            $this->view->setVar( 'noticia', new Noticia );
            return $this->view->pick("noticia/editar");
        }
        $categoriesIt = Category::find();
        
        $this->view->setVar('categoriesIt', $categoriesIt);
        $this->view->setVar('noticia', $noticia);
        $this->view->setVar('utility', $this->utility);
        
        $this->view->pick("noticia/editar");
    }
    
    public function updateAction() {
        $id = $this->request->get('id');
        
        if( false === $this->request->isPost() ) {
            return $this->response->redirect(array('for' => 'noticia.editar', 'id' => $id));
        }
        
        try {
            $this->noticiaBO->update($id, $this->request->getPost());
            
            $this->getFlash()->message('success', "Notícia id #{$id} editada com sucesso");        
            return $this->response->redirect(array('for' => 'noticia.lista'));
            
        } catch (ModelValidException $exc) {
            
            foreach ($exc->getValidator()->getMessages() as $message) {
                $this->getFlash()->message('error', $message);
            }
            
        } catch (Exception $exc) {
            $this->getFlash()->message('error', 'Houve um erro ao editar a notícia. Por favor, tente novamente.');            
        }
        
        $this->response->redirect(array('for' => 'noticia.editar', 'id' => $id));
    }

    public function salvarAction() {        
        if( false === $this->request->isPost() ) {
            return $this->response->redirect(array('for' => 'noticia.cadastrar'));
        }
        
        try {
            $this->noticiaBO->create($this->request->getPost());
            
            $this->getFlash()->message('success', 'Notícia cadastrada com sucesso');
            return $this->response->redirect(array('for' => 'noticia.lista'));
            
        } catch (ModelValidException $exc) {
            
            foreach ($exc->getValidator()->getMessages() as $message) {
                $this->getFlash()->message('error', $message);
            }
            
        } catch (Exception $exc) {
            $this->getFlash()->message('error', 'Houve um erro ao salvar a notícia. Por favor, tente novamente.');
        }
        
        $this->response->redirect(array('for' => 'noticia.cadastrar'));
    }

    public function excluirAction($id) {
        
        try {            
            $this->noticiaBO->delete($id);
            $this->getFlash()->message('success', 'Notícia excluída com sucesso!');
        } catch (Exception $exc) {
            $this->getFlash()->message('error', 'Houve um erro ao excluir a notícia. Tente novamente');
        }
        
        $this->response->redirect(array('for' => 'noticia.lista'));
    }

    /**
     * 
     * @return FlashSession
     */
    protected function getFlash() {
        return $this->flash = $this->flash ?: new FlashSession();
    }

}
