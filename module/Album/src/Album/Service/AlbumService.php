<?php

namespace Album\Service;


use Album\Model\Album;
//use \Doctrine\ORM\EntityRepository;
use Zend\Hydrator\ClassMethods;
use Album\Service\ServiceAbstract;

class AlbumService extends ServiceAbstract{
    protected $serviceLocator;
    protected $entity = Album::class;
    protected $em;
    
    public function __construct(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator) {
        $this->serviceLocator = $serviceLocator;
        $this->setEm();
    }
    
    public function setEm(){
        $this->em = $this->serviceLocator->get('Doctrine\ORM\EntityManager');
    }
    public function apagar(array $data) {
        $entity = $this->em->getRepository($this->entity)->findOneBy($data);
        
        if($entity){
            $this->em->remove($entity);
            $this->em->flush();
            
            return $entity;
        }
    }
    public function buscarPor(array $data){
        $albumDao = $this->em->getRepository($this->entity);
        return $albumDao->findOneBy($data);
    }
    public function salvarAlbum(array $data){
//        var_dump($data);
        if(isset($data['id'])){
//            echo "tem id";
            $entity = $this->em->getReference($this->entity, $data['id']);
            
            $hydrator = new ClassMethods();
            $hydrator->hydrate($data, $entity);
        } else {
            $entity = new $this->entity($data);
        }
//        var_dump($data);
        $this->em->persist($entity);
        $this->em->flush();
        
        return $entity;
    }
    /**
     * 
     * @return array
     */
    public function buscarTodos(){
        $albumDao = $this->em->getRepository($this->entity);
        return $albumDao->findAll();
    }    
}
