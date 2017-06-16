<?php

namespace Album\Service;

use Doctrine\ORM\EntityManager;
use Zend\Hydrator\ClassMethods;

abstract class ServiceAbstract {
    
    protected $em;
    protected $entity;
    
    public function __construct(EntityManager $em) {
        $this->em = $em;
    }
    
    public function save(Array $data = array()){
        if(isset($data['id'])){
            $entity = $em->getReference($this->entity, $data['id']);
            
            $hydrator = new ClassMethods();
            $hydrator->hydrate($data, $entity);
        } else {
            $entity = new $this->entity($data);
        }
        
        $this->em->persist($entity);
        $this->em->flush();
        
        return $entity;
    }
    
    function remove(Array $data = array()) {
        $entity = $this->em->getRepository($this->entity)->findOneBy($data);
        
        if($entity){
            $this->em->remove($entity);
            $this->em->flush();
            
            return $entity;
        }
        
    }
}
