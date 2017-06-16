<?php

namespace Album\Service;


use Album\Model\Album;

class AlbumService {
    protected $serviceLocator;
    protected $entity = Album::class;
    
    public function __construct(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator) {
        $this->serviceLocator = $serviceLocator;
    }
    
    public function salvarAlbum(){
        /**
         * @var $albumDao \Doctrine\ORM\EntityRepository 
         */
        $data = array();
        $em = $this->serviceLocator->get('Doctrine\ORM\EntityManager');
        $albumDao = $em->getRepository($this->entity);
        return $albumDao->save(new Album($data));
    }
    /**
     * 
     * @return array
     */
    public function buscarTodos(){
        $em = $this->serviceLocator->get('Doctrine\ORM\EntityManager');
        $albumDao = $em->getRepository($this->entity);
        return $albumDao->findAll();
    }    
}
