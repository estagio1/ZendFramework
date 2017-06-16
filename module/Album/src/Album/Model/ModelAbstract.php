<?php

namespace Album\Model;

use Zend\Hydrator\ClassMethods;

class ModelAbstract {
    /**
     * 
     * @param array $data
     */
    public function __construct(Array $data = array()) {
        $hydrator = new ClassMethods();
        $hydrator->hydrate($data, $this);
    }
    /**
     * 
     * @return array 
     */
    public function toArray() {
        $hydrator = new ClassMethods();
        return $hydrator->extract($this);
    }
}
