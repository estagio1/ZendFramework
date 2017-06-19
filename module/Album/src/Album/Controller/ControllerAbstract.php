<?php


namespace Album\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Doctrine\ORM\EntityManager;
use Zend\View\Model\ViewModel;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\ArrayAdapter;

abstract class ControllerAbstract extends AbstractActionController{
    
    protected $em;
    protected $entity;
    protected $controller;
    protected $route;
    protected $service;
    protected $form;
    
    abstract function __construct();
    /**
     * Listar Resultados
     * @return array|void
     */
    public function indexAction() {
        $list = $this->getEm()->getRepository($this->entity)->findAll();
        $page = $this->params()->fromRoute('page');
        $paginator = new Paginator(new ArrayAdapter($list));
        $paginator->setCurrentPageNumber($page)->setDefaultItemCountPerPage(10);
        return new ViewModel(['data' => $paginator, 'page' => $page]);
    }
    /**
     * Inserir um registro
     * @return array|void
     */
    public function inserirAction(){
        if(is_string($this->form)){
            $form = new $this->form;
        } else {
            $form = $this->form;
        }
        $request = $this->getRequest();
        
        if($request->isPost()){
            $form->setData($request->getPost());
            if($form->isValid()){
                $service = $this->getServiceLocator()->get($this->service);
                
                if($service->save($request->getPost()->toArray())){
                    $this->flashMessenger()->addSucessMessage('Cadastrado com sucesso!');
                } else {
                    $this->flashMessenger()->addErrorMessage('Não foi possivel cadastrar! Tente mais tarde.');
                }
                return $this->redirect()->toRoute($this->route, array('controller' => $this->controller));
            }
        }
        if($this->flashMessenger()->hasSuccessMensages()){
            return new ViewModel([
                'form' => $form,
                'success' => $this->flashMessenger()->getSuccessMessages()]);
        }
        if($this->flashMessenger()->hasErrorMensages()){
            return new ViewModel([
                'form' => $form,
                'success' => $this->flashMessenger()->getErrorMessages()]);
        }
        
        $this->flashMessenger()->clearMessages();
        return new ViewModel(['form' => $form]);
    }
    /**
     * Editar um registro
     * @return array|void
     */
    public function editarAction(){
        if(is_string($this->form)){
            $form = new $this->form;
        } else {
            $form = $this->form;
        }
        $request = $this->getRequest();
        $param = $this->params()->fromRoute('id', 0);
        $repository = $this->getEm()->getRepository($this->entity)->findOneBy($param);
        
        if($repository){
            if($request->isPost()){
                $form->setData($request->getPost());
                if($form->isValid()){
                    $service = $this->getServiceLocator()->get($this->service);
                    $data = $request->getPost()->toArray();
                    $data['id'] = $param;
                    if($service->save($data)){
                        $this->flashMessenger()->addSucessMessage('Atualizado com sucesso!');
                    } else {
                        $this->flashMessenger()->addErrorMessage('Não foi possivel atualizar! Tente mais tarde.');
                    }
                    return $this->redirect()->toRoute($this->route, array('controller' => $this->controller));
                }
            }
        } else {
            $this->flashMessenger()->addInfoMessage('Registro não foi encontrado!');
            return $this->redirect()->toRoute($this->route, array('controller' => $this->controller));
        }
        
        if($this->flashMessenger()->hasSuccessMensages()){
            return new ViewModel([
                'form' => $form,
                'success' => $this->flashMessenger()->getSuccessMessages(),
                'id' => $param]);
        }
        if($this->flashMessenger()->hasErrorMensages()){
            return new ViewModel([
                'form' => $form,
                'success' => $this->flashMessenger()->getErrorMessages(),
                'id' => $param]);
        }
        if($this->flashMessenger()->hasInfoMensages()){
            return new ViewModel([
                'form' => $form,
                'warning' => $this->flashMessenger()->getInfoMessages(),
                'id' => $param]);
        }
        $this->flashMessenger()->clearMessages();
        return new ViewModel(['form' => $form]);
    }
    /**
     * Excluir um registro
     * @return array|void
     */
    public function excluirAction(){
        
    }
    /**
     * 
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEm(){
        if($this->em == NULL){
            $this->em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }
        
        return $this->em;
    }
}
