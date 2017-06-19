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
    protected $serviceLocator;


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
    public function addAction(){
        if(is_string($this->form)){
            $form = new $this->form;
        } else {
            $form = $this->form;
        }
        $request = $this->getRequest();
        
        if($request->isPost()){
            $form->setData($request->getPost());
            if($form->isValid()){
                $this->serviceLocator = $this->getEvent()->getApplication()->getServiceManager();
                $service = $this->serviceLocator->get('Doctrine\ORM\EntityManager');
                $albumDao = $service->getRepository($this->entity);
                if($albumDao->save(new Album($request->getPost()->toArray()))){
                    $this->flashMessenger()->addSucessMessage('Cadastrado com sucesso!');
                } else {
                    $this->flashMessenger()->addErrorMessage('Não foi possivel cadastrar! Tente mais tarde.');
                }
                return $this->redirect()->toRoute($this->route, array('controller' => $this->controller));
            }
        }
        if($this->flashMessenger()->hasSuccessMessages()){
            return new ViewModel([
                'form' => $form,
                'success' => $this->flashMessenger()->getSuccessMessages()]);
        }
        if($this->flashMessenger()->hasErrorMessages()){
            return new ViewModel([
                'form' => $form,
                'success' => $this->flashMessenger()->getErrorMessages()]);
        }
        
        $this->flashMessenger()->clearMessages();
        return new ViewModel(['form' => $form]);
    }
    /**
     * Editar um registro implementado
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
            
            $arranjo = array();
            foreach ($repository->toArray() as $key => $value){
                if($value instanceof \DateTime){
                    $arranjo[$key] = $value->format("d/m/y");
                } else {
                    $arranjo[$key] = $value;
                }
            }
            $form->setData($request->getPost());
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
        
        if($this->flashMessenger()->hasSuccessMessages()){
            return new ViewModel([
                'form' => $form,
                'success' => $this->flashMessenger()->getSuccessMessages(),
                'id' => $param]);
        }
        if($this->flashMessenger()->hasErrorMessages()){
            return new ViewModel([
                'form' => $form,
                'error' => $this->flashMessenger()->getErrorMessages(),
                'id' => $param]);
        }
        if($this->flashMessenger()->hasInfoMessages()){
            return new ViewModel([
                'form' => $form,
                'warning' => $this->flashMessenger()->getInfoMessages(),
                'id' => $param]);
        }
        $this->flashMessenger()->clearMessages();
        return new ViewModel(['form' => $form, 'id' => $param]);
    }
    /**
     * Excluir um registro
     * @return array|void
     */
    public function excluirAction(){
        $service = $this->getServiceLocator()->get($this->service);
        $id = $this->params()->fromRoute('id', 0);
        if($service->remove(['id', $id])){
            $this->flashMessenger()->addSuccessMessage('Registro deletado com sucesso!');
        } else {
            $this->flashMessenger()->addErrorMessage('Não foi possivel deletar o registro!');
        }
        return $this->redirect()->toRoute($this->route, ['controller', $this->controller]);
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
