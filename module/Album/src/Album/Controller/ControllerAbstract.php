<?php


namespace Album\Controller;

use Zend\Mvc\Controller\AbstractActionController;
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
}
