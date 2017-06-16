<?php


namespace Album\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Doctrine\ORM\EntityManager;
use Zend\View\Model\ViewModel;

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
        
        return new ViewModel(['data' => $list]);
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
