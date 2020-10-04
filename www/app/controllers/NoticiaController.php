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
    
    public function initialize() {
        parent::initialize();
        
        $this->utility = new ModelUtil();
    }

    public function listaAction() {        
        $noticiasIt = Noticia::find();        
        
        $this->view->setVar('noticiasIt', $noticiasIt);
        
        $this->view->pick("noticia/listar");
    }

    public function cadastrarAction() {
        $categoriesIt = Category::find();
        
        $this->view->setVar('categoriesIt', $categoriesIt);
        
        $this->view->pick("noticia/cadastrar");
    }

    public function editarAction($id) {        
        $noticia = Noticia::findFirst((int) $id);
        
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
        
        $categories = $this->request->get('categories');
        $cat_ids = is_array( $categories ) ? $categories : [];
        
        // Start a transaction
        $this->db->begin();
        
        if ( ! $noticia->update() || !self::saveCategoriesInModel($noticia, $cat_ids) ) {
            $this->getFlash()->message('error', 'Houve um erro ao editar a notícia. Por favor, tente novamente.');
            
            // Rollback the transaction
            $this->db->rollback();
            
            return $this->response->redirect(array('for' => 'noticia.editar', 'id' => $id));
        }
        
        // Commit the transaction
        $this->db->commit();
        
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
        
        $categories = $this->request->get('categories');
        $cat_ids = is_array( $categories ) ? $categories : [];
        
        // Start a transaction
        $this->db->begin();

        if ( ! $noticia->save() || ! self::saveCategoriesInModel($noticia, $cat_ids) ) {
            $this->getFlash()->message('error', 'Houve um erro ao salvar a notícia. Por favor, tente novamente.');
            
            // Rollback the transaction
            $this->db->rollback();
            
            return $this->response->redirect(array('for' => 'noticia.cadastrar'));
        }
        
        // Commit the transaction
        $this->db->commit();

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
        $noticia = Noticia::findFirst((int) $id);
        
        if( FALSE === $noticia ) {
            $this->getFlash()->message('error', 'Essa Notícia não existe na base de dados.');
            return $this->response->redirect(array('for' => 'noticia.lista'));
        }        
        
        // Start a transaction
        $this->db->begin();
        
        self::cleanCategoriesOfModel($noticia);
        
        if( $noticia->delete() ) {
            $this->getFlash()->message('success', 'Notícia excluída com sucesso!');
            
            // Commit the transaction
            $this->db->commit();
        } else {
            $this->getFlash()->message('error', 'Houve um erro ao excluir a notícia. Tente novamente');
            
            // Rollback the transaction
            $this->db->rollback();
        }        
        
        return $this->response->redirect(array('for' => 'noticia.lista'));
    }

    /**
     * 
     * @return FlashSession
     */
    protected function getFlash() {
        return $this->flash = $this->flash ?: new FlashSession();
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
