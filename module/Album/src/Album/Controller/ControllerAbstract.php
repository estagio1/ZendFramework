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
        
    }
    /**
     * Editar um registro
     * @return array|void
     */
    public function editarAction(){
        
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
